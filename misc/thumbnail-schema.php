<?php

function getThumbnailSchema() {
    return array(
        'browserThumbnailLevels' => "CREATE TABLE browserThumbnailLevels (
            levelID INT NOT NULL PRIMARY KEY,
            publishedID INT DEFAULT NULL,
            updatedAt INT NOT NULL DEFAULT 0
        ) ENGINE=InnoDB",
        'browserThumbnailSubmissions' => "CREATE TABLE browserThumbnailSubmissions (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            levelID INT NOT NULL,
            accountID INT NOT NULL,
            revision INT NOT NULL DEFAULT 1,
            status VARCHAR(12) NOT NULL DEFAULT 'pending',
            isResubmit INT NOT NULL DEFAULT 0,
            reason VARCHAR(1000) NOT NULL DEFAULT '',
            reviewerID INT DEFAULT NULL,
            createdAt INT NOT NULL,
            updatedAt INT NOT NULL,
            reviewedAt INT DEFAULT NULL,
            imageHash CHAR(64) NOT NULL,
            imageWidth INT NOT NULL,
            imageHeight INT NOT NULL,
            fullPng MEDIUMBLOB NOT NULL,
            fullWebp MEDIUMBLOB NOT NULL,
            smallPng MEDIUMBLOB NOT NULL,
            smallWebp MEDIUMBLOB NOT NULL,
            INDEX thumbnailQueue (status, updatedAt),
            INDEX thumbnailOwner (accountID, levelID, status),
            INDEX thumbnailLevel (levelID, status)
        ) ENGINE=InnoDB",
        'browserThumbnailHistory' => "CREATE TABLE browserThumbnailHistory (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            submissionID INT NOT NULL,
            revision INT NOT NULL,
            action VARCHAR(24) NOT NULL,
            accountID INT NOT NULL,
            reason VARCHAR(1000) NOT NULL DEFAULT '',
            createdAt INT NOT NULL,
            INDEX thumbnailHistory (submissionID, id),
            INDEX thumbnailActivity (accountID, createdAt)
        ) ENGINE=InnoDB"
    );
}

function installThumbnailSchema($db) {
    foreach (getThumbnailSchema() as $_sql) {
        $db->exec(str_replace('CREATE TABLE ', 'CREATE TABLE IF NOT EXISTS ', $_sql));
    }
    $_query = $db->query("SHOW COLUMNS FROM roles LIKE 'ogdwApproveThumbnails'");
    if (!$_query->fetch()) {
        $db->exec("ALTER TABLE roles ADD ogdwApproveThumbnails INT NOT NULL DEFAULT '0' COMMENT 'Approve or reject level thumbnails in ObeyGDBrowser.'");
    }
}
