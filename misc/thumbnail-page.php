<?php

require_once __DIR__ . '/thumbnail-settings.php';
if (!getThumbnailSettings(readBrowserSettings())['enabled']) {
    http_response_code(404);
    exit('Thumbnails are disabled.');
}
$_OBEYGDBROWSER_FILEVERSION = 0;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_thumbnailModeration ? 'Moderate thumbnails' : 'Level thumbnails'; ?></title>
    <link rel="stylesheet" href="<?php echo $_thumbnailBase; ?>assets/css/browser.css">
    <link rel="stylesheet" href="<?php echo $_thumbnailBase; ?>assets/css/utils.css">
    <link rel="stylesheet" href="<?php echo $_thumbnailBase; ?>thumbnails/thumbnails.css">
    <script src="<?php echo $_thumbnailBase; ?>misc/jquery-3.7.1.min.js"></script>
</head>
<body class="thumbnail-page levelBG" data-moderation="<?php echo $_thumbnailModeration ? '1' : '0'; ?>">
    <a class="thumbnail-back" href="<?php echo $_thumbnailModeration ? '../index.php' : '../index.php'; ?>" aria-label="Back"><img class="gdButton" src="<?php echo $_thumbnailBase; ?>assets/back.png" alt=""></a>
    <a id="moderateThumbnails" class="thumbnail-moderate" href="<?php echo $_thumbnailBase; ?>moderation/thumbnails/index.php" hidden><img class="gdButton" src="<?php echo $_thumbnailBase; ?>assets/category-moderator.png" alt="Moderate thumbnails"></a>
    <main class="thumbnail-main purpleBox">
        <h1 class="font-gold-pusab"><?php echo $_thumbnailModeration ? 'Thumbnail moderation' : 'Level thumbnails'; ?></h1>
        <p class="thumbnail-help">Thumbnail API: unstable</p>
        <div id="thumbnailNotice" class="thumbnail-notice" role="status" tabindex="-1" hidden><img src="<?php echo $_thumbnailBase; ?>assets/exclamation.png" alt=""><p></p></div>
        <div id="thumbnailGuest" hidden>
            <h3>Log in to submit and track your thumbnails.</h3>
            <button id="thumbnailLogin" class="gdsButton" type="button"><span>Log in</span></button>
        </div>
        <button id="thumbnailInstall" class="gdsButton" type="button" hidden><span>Set up thumbnail tables</span></button>
        <section id="thumbnailWorkspace" hidden>
            <?php if (!$_thumbnailModeration) { ?>
            <form id="thumbnailForm" class="invisibleBox" enctype="multipart/form-data">
                <h2 id="thumbnailFormTitle">Submit a thumbnail</h2>
                <p class="thumbnail-help">PNG or WebP, up to 5 MB and 8 million pixels. Animated images are not accepted. One pending submission per level. Approved images stay unchanged while replacements are reviewed.</p>
                <div class="thumbnail-fields">
                    <label for="thumbnailLevelID">Level ID</label>
                    <input id="thumbnailLevelID" name="levelID" type="number" min="1" max="2147483647" step="1" required>
                    <div id="thumbnailLevelPicker"><select id="thumbnailLevels" class="gdsInput select" api-url="<?php echo $_thumbnailBase; ?>api/search.php" aria-label="Selected level"><option value="" hidden>Select a level</option></select></div>
                    <button id="thumbnailFindLevel" class="gdsButton blue" type="button"><span>Search levels</span></button>
                </div>
                <div class="thumbnail-file-row">
                    <button id="thumbnailChooseImage" class="gdsButton blue" type="button">Choose image</button>
                    <span id="thumbnailFilename" class="thumbnail-help">No image selected</span>
                    <input id="thumbnailFile" name="image" type="file" accept="image/png,image/webp,.png,.webp" aria-label="Image" hidden>
                </div>
                <img id="thumbnailUploadPreview" class="thumbnail-upload-preview" alt="Your image preview" hidden>
                <div class="thumbnail-actions">
                    <button id="thumbnailSubmit" class="gdsButton" type="submit"><span>Send for review</span></button>
                    <button id="thumbnailCancelEdit" class="gdsButton red" type="button" hidden><span>Cancel edit</span></button>
                </div>
            </form>
            <?php } ?>
            <nav id="thumbnailTabs" class="thumbnail-tabs" aria-label="Submission status">
                <button class="invisibleBox leaderboardCustomTab" data-status="pending" activetab="on" aria-pressed="true" type="button">Pending</button>
                <button class="invisibleBox leaderboardCustomTab" data-status="resubmits" activetab="off" aria-pressed="false" type="button">Resubmits</button>
                <button class="invisibleBox leaderboardCustomTab" data-status="approved" activetab="off" aria-pressed="false" type="button">Accepted</button>
                <button class="invisibleBox leaderboardCustomTab" data-status="rejected" activetab="off" aria-pressed="false" type="button">Rejected</button>
            </nav>
            <div class="thumbnail-filters">
                <label for="thumbnailSort">Order</label>
                <select id="thumbnailSort" class="gdsInput"><option value="newest">Most recent</option><option value="oldest">Oldest first</option><option value="requested">Most requested levels</option></select>
                <label for="thumbnailFilterLevel">Level ID</label>
                <input id="thumbnailFilterLevel" type="number" min="1" max="2147483647" step="1">
                <button id="thumbnailRefresh" class="gdsButton blue" type="button"><span>Refresh</span></button>
            </div>
            <p id="thumbnailQueueStatus" role="status"></p>
            <div id="thumbnailSubmissions" aria-live="polite"></div>
            <div class="thumbnail-pagination"><button id="thumbnailPrevious" class="gdsButton" type="button"><span>Previous</span></button><span id="thumbnailPage"></span><button id="thumbnailNext" class="gdsButton" type="button"><span>Next</span></button></div>
        </section>
    </main>
    <dialog id="thumbnailReview" class="purpleBox thumbnail-dialog" aria-labelledby="thumbnailReviewTitle">
        <button id="thumbnailReviewClose" class="thumbnail-close" type="button" aria-label="Close review"><img class="gdButton" src="<?php echo $_thumbnailBase; ?>assets/close.png" alt=""></button>
        <div class="thumbnail-review-content">
        <h2 id="thumbnailReviewTitle">Review thumbnail</h2>
        <p id="thumbnailReviewDetails"></p>
        <div class="thumbnail-compare"><figure><figcaption>Submission</figcaption><img id="thumbnailReviewImage" alt="Submitted thumbnail"></figure><figure id="thumbnailPublished" hidden><figcaption>Currently published</figcaption><img alt="Published thumbnail"></figure></div>
        <p id="thumbnailReviewNotice" class="thumbnail-help" role="alert"></p>
        <form id="thumbnailReviewForm">
            <label id="thumbnailReplaceLabel" for="thumbnailReplace" hidden><input id="thumbnailReplace" type="checkbox"> <span>Replace the current published thumbnail</span></label>
            <label for="thumbnailReason">Rejection reason or suggestions</label>
            <textarea id="thumbnailReason" maxlength="1000" rows="3"></textarea>
            <div class="modActionBox thumbnail-actions"><button id="thumbnailApprove" class="gdsButton" type="button"><span>Approve</span></button><button id="thumbnailReject" class="gdsButton red" type="button"><span>Reject</span></button></div>
        </form>
        </div>
    </dialog>
    <?php require __DIR__ . '/../assets/htmlext/flayeralert.php'; ?>
    <script src="<?php echo $_thumbnailBase; ?>misc/gdcustomframe.js"></script>
    <script src="<?php echo $_thumbnailBase; ?>misc/gdcustomalerts.js"></script>
    <script src="<?php echo $_thumbnailBase; ?>misc/thumbnails-ui.js"></script>
</body>
</html>
