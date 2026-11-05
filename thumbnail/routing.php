<?php

$_root = rtrim(str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_NAME']))), '/');
$_example = 'location ~* ^' . preg_quote($_root, '~') . '/thumbnail/(?<thumbnailPath>[1-9][0-9]*(?:\.(?:png|webp))?(?:/(?:SMALL|FULL|HIGH)(?:\.(?:png|webp))?)?)/?$ {
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME $document_root' . $_root . '/thumbnail/index.php;
    fastcgi_param SCRIPT_NAME ' . $_root . '/thumbnail/index.php;
    fastcgi_param PATH_INFO /$thumbnailPath;
    fastcgi_pass 127.0.0.1:9000;
}';
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Thumbnail routing</title><link rel="stylesheet" href="../assets/css/gdpssettings.css"></head>
<body>
    <fieldset><legend><h2>Thumbnail routing</h2></legend>
        <p>This API is unstable. Only approved thumbnails are public. GET and HEAD support full previews or SMALL (up to 320×180); full previews fit within 1920×1080 without changing proportions. PNG and WebP suffixes choose the actual response format. Without a suffix, the configured default is used.</p>
        <p>These URLs work without rewrite rules, including installations in subfolders:</p>
        <pre><?php echo htmlspecialchars($_root . '/thumbnail/index.php?id=123' . "\n" . $_root . '/thumbnail/index.php?id=123&size=small&format=png', ENT_QUOTES, 'UTF-8'); ?></pre>
        <p>Apache: enable mod_rewrite and AllowOverride FileInfo for the included thumbnail/.htaccess. Short URLs use thumbnail/123, thumbnail/123/SMALL, thumbnail/123.png or thumbnail/123.webp/SMALL.</p>
        <p>Nginx: add this location before generic PHP locations. Replace fastcgi_pass with your PHP-FPM socket or address and check that document_root matches your installation. Preserve any host-specific FastCGI security settings. Reload Nginx after validating the configuration.</p>
        <pre><?php echo htmlspecialchars($_example, ENT_QUOTES, 'UTF-8'); ?></pre>
        <p>Missing images return 404. Invalid paths or formats return 400. Disabled requests return 404 even if a thumbnail exists. Public images support ETag and five-minute caching; private submission previews require the browser session and are never publicly cached. No bearer token is needed for public images.</p>
        <p><a href="../gdpsettings/index.php">Back to configuration</a></p>
    </fieldset>
</body>
</html>
