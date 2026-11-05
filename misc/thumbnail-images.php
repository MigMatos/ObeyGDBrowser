<?php

class ThumbnailError extends RuntimeException {
    public $errorCode;
    public $httpStatus;

    public function __construct($errorCode, $message, $httpStatus = 422) {
        parent::__construct($message);
        $this->errorCode = $errorCode;
        $this->httpStatus = $httpStatus;
    }
}

function validateThumbnailContainer($bytes, $format) {
    $length = strlen($bytes);
    if ($format === 'png') {
        if (substr($bytes, 0, 8) !== "\x89PNG\r\n\x1a\n") {
            return false;
        }
        $_offset = 8;
        $_hasImage = false;
        while ($_offset + 12 <= $length) {
            $_size = unpack('N', substr($bytes, $_offset, 4))[1];
            $_type = substr($bytes, $_offset + 4, 4);
            if ($_size > $length - $_offset - 12 || !preg_match('/^[A-Za-z]{4}$/D', $_type)) {
                return false;
            }
            $_chunk = substr($bytes, $_offset + 4, $_size + 4);
            if (hash('crc32b', $_chunk, true) !== substr($bytes, $_offset + 8 + $_size, 4)) {
                return false;
            }
            if ($_offset === 8 && ($_type !== 'IHDR' || $_size !== 13)) {
                return false;
            }
            if (in_array($_type, array('acTL', 'fcTL', 'fdAT'), true)) {
                return false;
            }
            $_hasImage = $_hasImage || $_type === 'IDAT';
            $_offset += $_size + 12;
            if ($_type === 'IEND') {
                return $_size === 0 && $_hasImage && $_offset === $length;
            }
        }
        return false;
    }
    if (substr($bytes, 0, 4) !== 'RIFF' || substr($bytes, 8, 4) !== 'WEBP' || $length < 20 || unpack('V', substr($bytes, 4, 4))[1] !== $length - 8) {
        return false;
    }
    $_offset = 12;
    $_hasImage = false;
    while ($_offset + 8 <= $length) {
        $_type = substr($bytes, $_offset, 4);
        $_size = unpack('V', substr($bytes, $_offset + 4, 4))[1];
        if ($_size > $length - $_offset - 8 || !in_array($_type, array('VP8 ', 'VP8L', 'VP8X', 'ALPH', 'ICCP', 'EXIF', 'XMP '), true)) {
            return false;
        }
        if ($_type === 'VP8X' && ($_size !== 10 || (ord($bytes[$_offset + 8]) & 2))) {
            return false;
        }
        if ($_type === 'VP8 ' || $_type === 'VP8L') {
            if ($_hasImage) {
                return false;
            }
            $_hasImage = true;
        }
        $_offset += 8 + $_size + ($_size % 2);
    }
    return $_hasImage && $_offset === $length;
}

function encodeThumbnailImage($image, $maxWidth, $maxHeight, $format) {
    $_scale = min(1, $maxWidth / imagesx($image), $maxHeight / imagesy($image));
    $_width = max(1, (int) round(imagesx($image) * $_scale));
    $_height = max(1, (int) round(imagesy($image) * $_scale));
    $_canvas = imagecreatetruecolor($_width, $_height);
    try {
        imagealphablending($_canvas, false);
        imagesavealpha($_canvas, true);
        imagefill($_canvas, 0, 0, imagecolorallocatealpha($_canvas, 0, 0, 0, 127));
        imagecopyresampled($_canvas, $image, 0, 0, 0, 0, $_width, $_height, imagesx($image), imagesy($image));
        ob_start();
        try {
            $_success = $format === 'png' ? imagepng($_canvas, null, 6) : imagewebp($_canvas, null, 86);
            $_bytes = ob_get_contents();
        } finally {
            ob_end_clean();
        }
        if (!$_success || !$_bytes) {
            throw new ThumbnailError('ENCODER_UNAVAILABLE', 'Image conversion is unavailable.', 503);
        }
        return $_bytes;
    } finally {
        imagedestroy($_canvas);
    }
}

function prepareThumbnailImage($bytes, $filename) {
    if (!function_exists('imagecreatefromstring') || !function_exists('imagewebp') || !class_exists('finfo')) {
        throw new ThumbnailError('IMAGE_SUPPORT_UNAVAILABLE', 'Enable PHP GD with PNG/WebP support and Fileinfo to upload thumbnails.', 503);
    }
    if (!is_string($bytes) || strlen($bytes) > 5 * 1024 * 1024 || strlen($bytes) < 20) {
        throw new ThumbnailError('IMAGE_SIZE', 'Choose a PNG or WebP image up to 5 MB.');
    }
    $format = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    if (!in_array($format, array('png', 'webp'), true) || !validateThumbnailContainer($bytes, $format)) {
        throw new ThumbnailError('IMAGE_FORMAT', 'Only complete, non-animated PNG or WebP images are accepted.');
    }
    $_mime = (new finfo(FILEINFO_MIME_TYPE))->buffer($bytes);
    $_info = @getimagesizefromstring($bytes);
    if ($_mime !== 'image/' . $format || !$_info || $_info['mime'] !== $_mime) {
        throw new ThumbnailError('IMAGE_FORMAT', 'The file contents do not match a PNG or WebP image.');
    }
    if ($_info[0] > 4096 || $_info[1] > 4096 || $_info[0] * $_info[1] > 8000000) {
        throw new ThumbnailError('IMAGE_DIMENSIONS', 'Images must fit within 4096 by 4096 pixels and 8 million pixels.');
    }
    $_image = @imagecreatefromstring($bytes);
    if (!$_image) {
        throw new ThumbnailError('IMAGE_DECODE', 'This image is damaged or could not be decoded.');
    }
    try {
        return array(
            'imageHash' => hash('sha256', $bytes),
            'imageWidth' => $_info[0],
            'imageHeight' => $_info[1],
            'fullPng' => encodeThumbnailImage($_image, 1920, 1080, 'png'),
            'fullWebp' => encodeThumbnailImage($_image, 1920, 1080, 'webp'),
            'smallPng' => encodeThumbnailImage($_image, 320, 180, 'png'),
            'smallWebp' => encodeThumbnailImage($_image, 320, 180, 'webp')
        );
    } finally {
        imagedestroy($_image);
    }
}
