<?php


include("../_init_.php");


if ($isAdmin != "1" || $logged != true) {
    header("Location: ../");
    exit();
} else {
    // echo "Please wait...";
}


$owner = 'MigMatos';
$repo = 'ObeyGDBrowser';

$latestReleaseUrl = getLatestReleaseUrl($owner, $repo);
$version_file_path = './version.txt';
$current_version = trim(file_get_contents($version_file_path));
if ($current_version == $latestReleaseUrl) {
    header("Location: ../?alert=lasted"); exit();};

function getLatestReleaseUrl($owner, $repo) {
    $url = "https://api.github.com/repos/$owner/$repo/releases/latest";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['User-Agent: PHP']);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
    if (isset($data['tag_name'])) {
        return $data['tag_name'];
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



function deleteFilesRecursively($folder) {

    foreach(glob($folder . '/*') as $file) {
        if (is_dir($file)) {
            if (strpos($file, 'update/') === false || strpos($file, 'gdps_settings.json') === false) deleteFilesRecursively($file);
            deleteFilesRecursively($file);
        } else {
            if (strpos($file, 'update/') === false || strpos($file, 'gdps_settings.json') === false) {unlink($file);}
        }
    }
}



function moveFilesToCurrentDirectory($sourceDir) {
    $sourceDir = "./" . rtrim($sourceDir, '/');
    $destinationDir = '../../browser/';
    $files = scandir($sourceDir);

    //print_r($files);
    //print_r($sourceDir);
    //echo "$files";
    //return;
    //return "";

    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $sourcePath = $sourceDir . '/' . $file;
            $destinationPath = $destinationDir . $file;
            if (is_dir($sourcePath)) {
                if(!rename($sourcePath, $destinationPath)){

                    deleteFilesRecursively($destinationPath);
                    
                    rename($sourcePath, $destinationPath);
                    unlink($destinationPath);
                }
            } else {
                copy($sourcePath, $destinationPath);
                unlink($sourcePath);
            }
        }
    }
    rmdir("./".$sourceDir);
    return true;
}




if ($latestReleaseUrl) {


$dir = "https://codeload.github.com/MigMatos/ObeyGDBrowser/zip/refs/tags/$latestReleaseUrl";
$dir = downloadAndExtractRepo($dir);


moveFilesToCurrentDirectory($dir);
unlink("../browser/installer.php");


header("Location: ../?alert=installed");

}