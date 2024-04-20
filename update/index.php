<?php

$repo_owner = 'migmatos';
$repo_name = 'obeybrowser';

$version_file_path = './version.txt';
$current_version = trim(file_get_contents($version_file_path));

$url = "https://api.github.com/repos/{$repo_owner}/{$repo_name}/tags";

$data = file_get_contents($url);

$tags = json_decode($data, true);

if ($tags) {
    $latest_tag = $tags[0]['name'];

    if ($current_version === $latest_tag) {
        echo "The version {$current_version} is the latest.";
    } else {
        echo "A new version is available. The latest version is {$latest_tag}.";
        file_put_contents($version_file_path, $latest_tag);
    }

    $download_url = "https://github.com/{$repo_owner}/{$repo_name}/archive/{$latest_tag}.zip";

    $zip_file = file_get_contents($download_url);

    $zip_file_path = "{$repo_name}-{$latest_tag}.zip";
    file_put_contents($zip_file_path, $zip_file);

    $zip = new ZipArchive;
    if ($zip->open($zip_file_path) === TRUE) {
        $zip->extractTo('./');

        $replace_assets = true;
        if (!$replace_assets) {
            $assets_folder = "{$repo_name}-{$latest_tag}/assets/";
            if ($zip->locateName($assets_folder) !== false) {
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $filename = $zip->getNameIndex($i);
                    if (strpos($filename, $assets_folder) === false) {
                        $zip->extractTo('./', array($filename));
                    }
                }
            }
        }

        $zip->close();
        echo " The file '{$zip_file_path}' has been downloaded and extracted successfully.";
    } else {
        echo "Couldn't open the file '{$zip_file_path}'";
    }

    unlink($zip_file_path);
} else {
    echo "Couldn't fetch tags from the repository.";
}
?>
