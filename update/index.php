<?php


include("../_init_.php");

function getLatestReleaseUrl($owner, $repo) {
    $url = "https://api.github.com/repos/$owner/$repo/releases/latest";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['User-Agent: PHP']);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
    if (isset($data['html_url'])) {
        return $data['html_url'];
    } else {
        return false;
    }
}

function downloadAndExtractRepo($repoUrl) {
    $zipFile = 'repo.zip';
    file_put_contents($zipFile, fopen($repoUrl, 'r'));
    if (file_exists($zipFile)) {
        $zip = new ZipArchive;
        if ($zip->open($zipFile) === TRUE) {
            $zip->extractTo('./');
            $firstDir = $zip->getNameIndex(0);
            $zip->close();
            unlink($zipFile);
            return $firstDir;
        } else {
            return -1;
        }
    } else {
        return -2;
    }
}

function moveFilesToCurrentDirectory($sourceDir) {
    $sourceDir = rtrim($sourceDir, '/');
    $destinationDir = './';
    $files = scandir("./".$sourceDir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $sourcePath = $sourceDir . '/' . $file;
            $destinationPath = $destinationDir . $file;
            if (is_dir($sourcePath)) {
                rename($sourcePath, $destinationPath);
            } else {
                copy($sourcePath, $destinationPath);
                unlink($sourcePath);
            }
        }
    }
    unlink("./".$sourceDir);
    return true;
}

$version_file_path = './version.txt';
$current_version = trim(file_get_contents($version_file_path));

$repo_owner = 'migmatos';
$repo_name = 'ObeyGDBrowser';


$url = "https://api.github.com/repos/{$repo_owner}/{$repo_name}/tags";

$data = file_get_contents($url);

$tags = json_decode($data, true);

if ($tags) {
    $latest_tag = $tags[0]['name'];
    if ($current_version === $latest_tag) header("Location: ./?alert=lasted");
}

if (!$isAdmin || !$logged) header("./");

$latestReleaseUrl = getLatestReleaseUrl($owner, $repo);
if ($latestReleaseUrl) {



$dir = downloadAndExtractRepo($latestReleaseUrl);
moveFilesToCurrentDirectory($dir);
header("Location: ./?alert=installed");

}