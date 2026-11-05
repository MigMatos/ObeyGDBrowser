<?php

require_once __DIR__ . '/thumbnail-settings.php';
require_once __DIR__ . '/thumbnail-images.php';
require_once __DIR__ . '/thumbnail-schema.php';
require_once __DIR__ . '/../api/actions.php';

function thumbnailId($value) {
    if ((!is_string($value) && !is_int($value)) || !preg_match('/^[1-9][0-9]{0,9}$/D', (string) $value) || $value > 2147483647) {
        throw new ThumbnailError('INVALID_ID', 'Provide a positive level or submission ID.', 400);
    }
    return (int) $value;
}

function thumbnailIdentity($db, $session) {
    $identity = array('accountID' => 0, 'isAdmin' => false, 'canModerate' => false);
    if (empty($session['accountID']) || empty($session['userID']) || empty($session['userName'])) {
        return $identity;
    }
    $_query = $db->prepare('SELECT accountID, isAdmin FROM accounts WHERE accountID = ?');
    $_query->execute(array(thumbnailId($session['accountID'])));
    $_account = $_query->fetch(PDO::FETCH_ASSOC);
    if (!$_account) {
        return $identity;
    }
    $identity['accountID'] = (int) $_account['accountID'];
    $identity['isAdmin'] = (int) $_account['isAdmin'] === 1;
    $identity['canModerate'] = $identity['isAdmin'];
    if (!$identity['isAdmin']) {
        try {
            $_query = $db->prepare('SELECT r.ogdwApproveThumbnails FROM roleassign ra JOIN roles r ON r.roleID = ra.roleID WHERE ra.accountID = ? ORDER BY r.priority DESC LIMIT 1');
            $_query->execute(array($identity['accountID']));
            $identity['canModerate'] = (int) $_query->fetchColumn() === 1;
        } catch (PDOException $_error) {
            $identity['canModerate'] = false;
        }
    }
    return $identity;
}

class BrowserThumbnails {
    private $db;
    private $identity;

    public function __construct($db, $identity) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db = $db;
        $this->identity = $identity;
    }

    private function requireAccount($moderator = false) {
        if (empty($this->identity['accountID'])) {
            throw new ThumbnailError('LOGIN_REQUIRED', 'Log in to manage thumbnails.', 401);
        }
        if ($moderator && empty($this->identity['canModerate'])) {
            throw new ThumbnailError('PERMISSION_REQUIRED', 'Thumbnail approval permission is required.', 403);
        }
    }

    private function query($sql, $values = array()) {
        $_query = $this->db->prepare($sql);
        $_query->execute($values);
        return $_query;
    }

    private function lockLevel($levelID) {
        $_level = $this->query('SELECT levelID FROM levels WHERE levelID = ? FOR UPDATE', array($levelID))->fetchColumn();
        if (!$_level) {
            throw new ThumbnailError('LEVEL_NOT_FOUND', 'This level no longer exists.', 404);
        }
        $this->query('INSERT IGNORE INTO browserThumbnailLevels (levelID) VALUES (?)', array($levelID));
        return $this->query('SELECT * FROM browserThumbnailLevels WHERE levelID = ? FOR UPDATE', array($levelID))->fetch(PDO::FETCH_ASSOC);
    }

    private function history($submissionID, $revision, $action, $reason = '') {
        $this->query('INSERT INTO browserThumbnailHistory (submissionID, revision, action, accountID, reason, createdAt) VALUES (?, ?, ?, ?, ?, ?)', array($submissionID, $revision, $action, $this->identity['accountID'], $reason, time()));
    }

    public function checkUploadBudget($isNewSubmission) {
        $this->requireAccount();
        $_recent = $this->query('SELECT COUNT(*) FROM browserThumbnailHistory WHERE accountID = ? AND createdAt > ? AND action IN (?, ?, ?)', array($this->identity['accountID'], time() - 3600, 'submitted', 'edited', 'resubmitted'))->fetchColumn();
        if ($_recent >= 20) {
            throw new ThumbnailError('RATE_LIMIT', 'You can submit or edit up to 20 thumbnails per hour.', 429);
        }
        if ($isNewSubmission) {
            $_pending = $this->query("SELECT COUNT(*) FROM browserThumbnailSubmissions WHERE accountID = ? AND status = 'pending'", array($this->identity['accountID']))->fetchColumn();
            if ($_pending >= 20) {
                throw new ThumbnailError('PENDING_LIMIT', 'Review your 20 pending submissions before sending more.', 429);
            }
        }
    }

    public function submit($levelID, $revision, $submissionID, $image) {
        $this->requireAccount();
        $levelID = thumbnailId($levelID);
        $accountID = $this->identity['accountID'];
        $this->db->beginTransaction();
        try {
            $this->lockLevel($levelID);
            if (!$this->query('SELECT accountID FROM accounts WHERE accountID = ? FOR UPDATE', array($accountID))->fetchColumn()) {
                throw new ThumbnailError('LOGIN_REQUIRED', 'Log in to manage thumbnails.', 401);
            }
            $this->checkUploadBudget(!$submissionID);
            $_pending = $this->query("SELECT id FROM browserThumbnailSubmissions WHERE accountID = ? AND levelID = ? AND status = 'pending'", array($accountID, $levelID))->fetchColumn();
            if ($submissionID) {
                $submissionID = thumbnailId($submissionID);
                $revision = thumbnailId($revision);
                $_row = $this->query('SELECT * FROM browserThumbnailSubmissions WHERE id = ? FOR UPDATE', array($submissionID))->fetch(PDO::FETCH_ASSOC);
                if (!$_row || (int) $_row['accountID'] !== $accountID || (int) $_row['levelID'] !== $levelID) {
                    throw new ThumbnailError('SUBMISSION_NOT_FOUND', 'Submission not found.', 404);
                }
                if ($_row['status'] === 'approved') {
                    throw new ThumbnailError('APPROVED_IMMUTABLE', 'Approved submissions cannot be edited. Send a new replacement proposal.', 409);
                }
                if ((string) $_row['revision'] !== (string) $revision || ($_pending && (int) $_pending !== $submissionID)) {
                    throw new ThumbnailError('REVISION_CONFLICT', 'This submission changed. Refresh before editing.', 409);
                }
                $_revision = (int) $_row['revision'] + 1;
                $_action = $_row['status'] === 'rejected' ? 'resubmitted' : 'edited';
                $_resubmit = $_row['isResubmit'] || $_row['status'] === 'rejected';
                $this->query("UPDATE browserThumbnailSubmissions SET revision = ?, status = 'pending', isResubmit = ?, reason = '', reviewerID = NULL, reviewedAt = NULL, updatedAt = ?, imageHash = ?, imageWidth = ?, imageHeight = ?, fullPng = ?, fullWebp = ?, smallPng = ?, smallWebp = ? WHERE id = ?", array($_revision, (int) $_resubmit, time(), $image['imageHash'], $image['imageWidth'], $image['imageHeight'], $image['fullPng'], $image['fullWebp'], $image['smallPng'], $image['smallWebp'], $submissionID));
            } else {
                if ($_pending) {
                    throw new ThumbnailError('PENDING_EXISTS', 'You already have a pending submission for this level. Edit it instead.', 409);
                }
                $_resubmit = $this->query('SELECT id FROM browserThumbnailSubmissions WHERE levelID = ? AND accountID = ? LIMIT 1', array($levelID, $accountID))->fetchColumn() !== false;
                $this->query('INSERT INTO browserThumbnailSubmissions (levelID, accountID, isResubmit, createdAt, updatedAt, imageHash, imageWidth, imageHeight, fullPng, fullWebp, smallPng, smallWebp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($levelID, $accountID, (int) $_resubmit, time(), time(), $image['imageHash'], $image['imageWidth'], $image['imageHeight'], $image['fullPng'], $image['fullWebp'], $image['smallPng'], $image['smallWebp']));
                $submissionID = (int) $this->db->lastInsertId();
                $_revision = 1;
                $_action = $_resubmit ? 'resubmitted' : 'submitted';
            }
            $this->history($submissionID, $_revision, $_action);
            $this->db->commit();
            return array('id' => $submissionID, 'revision' => $_revision, 'status' => 'pending');
        } catch (Throwable $_error) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $_error;
        }
    }

    public function review($submissionID, $revision, $decision, $reason, $publishedID, $replace) {
        $this->requireAccount(true);
        $submissionID = thumbnailId($submissionID);
        $revision = thumbnailId($revision);
        if (!in_array($decision, array('approve', 'reject'), true) || !is_string($reason) || strlen($reason) > 1000 || !preg_match('//u', $reason) || ($decision === 'reject' && trim($reason) === '')) {
            throw new ThumbnailError('INVALID_REVIEW', 'Choose approve or reject and include a rejection reason (up to 1000 bytes).', 400);
        }
        $_levelID = $this->query('SELECT levelID FROM browserThumbnailSubmissions WHERE id = ?', array($submissionID))->fetchColumn();
        if (!$_levelID) {
            throw new ThumbnailError('SUBMISSION_NOT_FOUND', 'Submission not found.', 404);
        }
        $this->db->beginTransaction();
        try {
            $_level = $this->lockLevel((int) $_levelID);
            $_row = $this->query('SELECT * FROM browserThumbnailSubmissions WHERE id = ? FOR UPDATE', array($submissionID))->fetch(PDO::FETCH_ASSOC);
            if ($_row['status'] !== 'pending' || (string) $_row['revision'] !== (string) $revision) {
                throw new ThumbnailError('REVISION_CONFLICT', 'This submission was edited or reviewed. Reload its preview before deciding.', 409);
            }
            if ($decision === 'approve') {
                if ((string) ($_level['publishedID'] ?? 0) !== (string) $publishedID || ($_level['publishedID'] && !$replace)) {
                    throw new ThumbnailError('REPLACEMENT_CONFIRMATION', 'The published thumbnail changed or needs explicit replacement approval. Reload and confirm.', 409);
                }
                $this->query('UPDATE browserThumbnailLevels SET publishedID = ?, updatedAt = ? WHERE levelID = ?', array($submissionID, time(), $_levelID));
            }
            $_status = $decision === 'approve' ? 'approved' : 'rejected';
            $this->query('UPDATE browserThumbnailSubmissions SET status = ?, reason = ?, reviewerID = ?, reviewedAt = ?, updatedAt = ? WHERE id = ?', array($_status, trim($reason), $this->identity['accountID'], time(), time(), $submissionID));
            $this->history($submissionID, (int) $_row['revision'], $_status, trim($reason));
            $_actionReason = substr(trim($reason), 0, 255);
            while ($_actionReason !== '' && !preg_match('//u', $_actionReason)) {
                $_actionReason = substr($_actionReason, 0, -1);
            }
            setModAction($decision === 'approve' ? 'APPROVE_THUMBNAIL' : 'REJECT_THUMBNAIL', array('value' => (string) $_levelID, 'value2' => $_actionReason, 'value3' => $submissionID, 'value5' => (int) $_row['revision'], 'value6' => (int) ($_level['publishedID'] ?? 0)), $this->db, $this->identity['accountID']);
            $this->db->commit();
            return array('id' => $submissionID, 'revision' => (int) $_row['revision'], 'status' => $_status);
        } catch (Throwable $_error) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $_error;
        }
    }

    public function listing($params, $moderation = false) {
        $this->requireAccount($moderation);
        $status = $params['status'] ?? 'pending';
        if (!in_array($status, array('pending', 'approved', 'rejected', 'resubmits'), true)) {
            throw new ThumbnailError('INVALID_FILTER', 'Choose a valid submission tab.', 400);
        }
        $order = array('newest' => 's.updatedAt DESC, s.id DESC', 'oldest' => 's.updatedAt ASC, s.id ASC', 'requested' => 'requestCount DESC, s.updatedAt ASC, s.id ASC');
        if (!isset($order[$params['sort'] ?? 'newest'])) {
            throw new ThumbnailError('INVALID_SORT', 'Choose a valid sort order.', 400);
        }
        $_where = array($status === 'resubmits' ? "s.status = 'pending' AND s.isResubmit = 1" : 's.status = ?');
        $_values = $status === 'resubmits' ? array() : array($status);
        if (!$moderation) {
            $_where[] = 's.accountID = ?';
            $_values[] = $this->identity['accountID'];
        }
        if (!empty($params['levelID'])) {
            $_where[] = 's.levelID = ?';
            $_values[] = thumbnailId($params['levelID']);
        }
        $_page = filter_var($params['page'] ?? 0, FILTER_VALIDATE_INT, array('options' => array('min_range' => 0, 'max_range' => 100000)));
        if ($_page === false) {
            throw new ThumbnailError('INVALID_PAGE', 'Choose a valid page.', 400);
        }
        $_total = $this->query('SELECT COUNT(*) FROM browserThumbnailSubmissions s WHERE ' . implode(' AND ', $_where), $_values)->fetchColumn();
        $_sql = 'SELECT s.id, s.levelID, s.accountID, s.revision, s.status, s.isResubmit, s.reason, s.reviewerID, s.createdAt, s.updatedAt, s.reviewedAt, s.imageWidth, s.imageHeight, l.levelName, a.userName, p.publishedID, (SELECT COUNT(*) FROM browserThumbnailSubmissions q WHERE q.levelID = s.levelID AND q.status = \'pending\') AS requestCount, (SELECT h.action FROM browserThumbnailHistory h WHERE h.submissionID = s.id ORDER BY h.id DESC LIMIT 1) AS lastAction FROM browserThumbnailSubmissions s LEFT JOIN levels l ON l.levelID = s.levelID LEFT JOIN accounts a ON a.accountID = s.accountID LEFT JOIN browserThumbnailLevels p ON p.levelID = s.levelID WHERE ' . implode(' AND ', $_where) . ' ORDER BY ' . $order[$params['sort'] ?? 'newest'] . ' LIMIT 20 OFFSET ' . ($_page * 20);
        $_rows = $this->query($_sql, $_values)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($_rows as &$_row) {
            foreach (array('id', 'levelID', 'accountID', 'revision', 'isResubmit', 'requestCount', 'publishedID', 'createdAt', 'updatedAt', 'imageWidth', 'imageHeight') as $_key) {
                $_row[$_key] = (int) $_row[$_key];
            }
        }
        return array('items' => $_rows, 'total' => (int) $_total, 'page' => $_page);
    }

    public function lookup($ids) {
        if (!is_string($ids) || strlen($ids) > 1100) {
            throw new ThumbnailError('INVALID_IDS', 'Provide up to 100 level IDs.', 400);
        }
        $_ids = array_values(array_unique(array_map('thumbnailId', explode(',', $ids))));
        if (count($_ids) > 100) {
            throw new ThumbnailError('INVALID_IDS', 'Provide up to 100 level IDs.', 400);
        }
        return $this->query('SELECT t.levelID, t.publishedID FROM browserThumbnailLevels t JOIN levels l ON l.levelID = t.levelID JOIN browserThumbnailSubmissions s ON s.id = t.publishedID AND s.status = \'approved\' WHERE t.levelID IN (' . implode(',', array_fill(0, count($_ids), '?')) . ')', $_ids)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function image($id, $size, $format, $preview = false, $revision = null) {
        $id = thumbnailId($id);
        if (!in_array($size, array('full', 'small'), true) || !in_array($format, array('png', 'webp'), true)) {
            throw new ThumbnailError('INVALID_IMAGE', 'Choose full or SMALL and PNG or WebP.', 400);
        }
        $_column = $size . ($format === 'png' ? 'Png' : 'Webp');
        if ($preview) {
            $this->requireAccount();
            $revision = thumbnailId($revision);
            $_row = $this->query('SELECT accountID, revision, ' . $_column . ' AS bytes FROM browserThumbnailSubmissions WHERE id = ?', array($id))->fetch(PDO::FETCH_ASSOC);
            if ($_row && (int) $_row['accountID'] !== $this->identity['accountID'] && !$this->identity['canModerate']) {
                $_row = false;
            }
            if ($_row && (string) $_row['revision'] !== (string) $revision) {
                throw new ThumbnailError('REVISION_CONFLICT', 'The preview changed. Reload before reviewing.', 409);
            }
        } else {
            $_row = $this->query('SELECT s.' . $_column . ' AS bytes FROM browserThumbnailLevels p JOIN browserThumbnailSubmissions s ON s.id = p.publishedID AND s.status = \'approved\' JOIN levels l ON l.levelID = p.levelID WHERE p.levelID = ?', array($id))->fetch(PDO::FETCH_ASSOC);
        }
        if (!$_row) {
            throw new ThumbnailError('IMAGE_NOT_FOUND', 'Thumbnail not found.', 404);
        }
        return $_row['bytes'];
    }
}
