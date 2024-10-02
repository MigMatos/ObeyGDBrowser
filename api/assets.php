<?php
header('Content-Type: application/json');

error_reporting(0);

function getFiles($directory) {
    $files = [];
    if (is_dir($directory)) {
        $dirHandle = opendir($directory);
        while (($file = readdir($dirHandle)) !== false) {
            if ($file !== '.' && $file !== '..') {
                $filePath = $directory . '/' . $file;
                if (is_dir($filePath)) {
                    $files[] = [
                        'name' => $file,
                        'type' => 'folder',
                        'url' => $filePath,
                        'children' => getFiles($filePath)
                    ];
                } else {
                    $fileType = pathinfo($filePath, PATHINFO_EXTENSION);
                    $files[] = [
                        'name' => $file,
                        'type' => ($fileType === 'jpg' || $fileType === 'png' || $fileType === 'jpeg') ? 'image' : $fileType,
                        'url' => $filePath,
                    ];
                }
            }
        }
        closedir($dirHandle);
    }
    return $files;
}

$directory = '../assets'; 
$files = getFiles($directory);
echo json_encode($files);