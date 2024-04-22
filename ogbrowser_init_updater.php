<?php

if (file_exists("./browser/_init_.php")) {
    include("./browser/_init_.php");
} else {
    echo "Error: GD Browser installation not found.";
    exit();
}


if ($isAdmin != "1" || $logged != true) {
    header("Location: ../browser/");
    exit();
} else {
    // echo "Please wait...";
}

/*

Functions

*/


function rmdir_recursive($dir) {

    $dir = rtrim($dir, '/');

    if (!file_exists($dir)) {
        return;
    }
    
    $files = array_diff(scandir($dir), array('.', '..'));

    foreach ($files as $file) {
        $path = $dir . '/' . $file;

        if (strpos($path, "browser/gdps_settings.json") === false && strpos($path, "/browser/customfiles/") === false) {
            if (is_dir($path)) {
                rmdir_recursive($path);
            } else {
                unlink($path);
            }

        }
    }
    
    rmdir($dir);
}




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

function downloadAndExtractRepo($setDir,$repoUrl) {
    $zipFile = 'ogdbrowser_sourcecode.zip';
    file_put_contents($zipFile, fopen($repoUrl, 'r'));
    if (file_exists($zipFile)) {
        $zip = new ZipArchive;
        if ($zip->open($zipFile) === TRUE) {
            $zip->extractTo($setDir);
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

function moveFilesToCurrentDirectory($currentDir,$sourceDir) {
    $sourceDir = $currentDir . rtrim($sourceDir, '/');
    $destinationDir = './'. $currentDir;
    $files = scandir("./" . $sourceDir);
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
    rmdir("./".$sourceDir);
    return true;
}

/* 

Updater code
 
*/

$owner = 'MigMatos';
$repo = 'ObeyGDBrowser';

$folder_browser = "browser/";

$latestTagVersion = getLatestReleaseUrl($owner, $repo);


$version_file_path = "./" . $folder_browser . 'update/version.txt';
$current_version = trim(file_get_contents($version_file_path));
if ($current_version == $latestTagVersion) {
    header("Location: ./".$folder_browser."?alert=lasted"); 
    exit();
};

/*

    Download from Github

*/

$latestReleaseUrl = "https://codeload.github.com/MigMatos/ObeyGDBrowser/zip/refs/tags/" . $latestTagVersion;

rmdir_recursive("./" . $folder_browser); //Deleting actually version without configuration file!
$dir = downloadAndExtractRepo("./" . "browser", $latestReleaseUrl);
if($dir === -1 || $dir === -2){
    header("Location: ./". $folder_browser ."?alert=failedinstall");
    exit();
}
moveFilesToCurrentDirectory($folder_browser , $dir);

rmdir_recursive("./" . $folder_browser . $dir . "/"); //Deleting the files unzipped

file_put_contents($version_file_path , "" . $latestTagVersion);
unlink("./" .$folder_browser . "installer.php");
unlink("./" .$folder_browser . "README.md");
header("Location: ./". $folder_browser ."?alert=installed");
?>