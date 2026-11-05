<?php

require_once __DIR__ . '/song-settings.php';

function getThumbnailSettings($settings) {
    $_settings = $settings['thumbnails'] ?? array();
    return array(
        'enabled' => isIconOptionEnabled($_settings['enabled'] ?? true),
        'defaultFormat' => ($_settings['defaultFormat'] ?? 'webp') === 'png' ? 'png' : 'webp'
    );
}

function getPostedThumbnailSettings($post, $settings) {
    $result = $settings['thumbnails'] ?? array();
    if (!isset($post['thumbnailSettingsSubmitted'])) {
        return $result;
    }
    if (!in_array($post['thumbnailDefaultFormat'] ?? null, array('png', 'webp'), true)) {
        throw new InvalidArgumentException('Choose PNG or WebP for thumbnails.');
    }
    $result['enabled'] = isset($post['thumbnailsEnabled']);
    $result['defaultFormat'] = $post['thumbnailDefaultFormat'];
    return $result;
}
