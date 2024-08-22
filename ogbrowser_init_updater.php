<?php
header('Content-Type: text/plain');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('Content-Encoding: none');
$error_installer = false;

if (file_exists("./browser/_init_.php")) {
    include("./browser/_init_.php");
} else {

    if (file_exists("./ogdbrowser_sourcecode.zip")) {
        $isAdmin = 1;
        $logged = true;
        $error_installer = true;
        unlink("./ogdbrowser_sourcecode.zip");

    } else {
        echo "Error: GD Browser installation not found. <br> Re-install from https://github.com/MigMatos/ObeyGDBrowser/releases/latest";
        exit();
    }

    
}


if ($isAdmin != "1" || $logged != true) {
    http_response_code(401);
    echo "Unauthorized access. You need to log in to access this page.";
    exit();
}

set_time_limit(0); 

/*

    OGDB Updater

*/


class OGDBrowserUpdater
{
    private $updateDir;
    private $targetDir;
    private $repoUrl;
    private $fileLogger;
    private $progressPercentage = 0;

    public function __construct($targetDir, $repoUrl)
    {
        $this->targetDir = rtrim($targetDir, '/');
        $this->repoUrl = $repoUrl;
        $this->fileLogger = $this->targetDir . "/update/log.txt";
    }

    public function run()
    {
        $this->progressPercentage = 20;
        $this->downloadAndExtractRepo();

        $this->progressPercentage = 40;
        $json = $this->compareDirectories();

        $this->progressPercentage = 60;
        $this->updateFiles($json);

        $this->progressPercentage = 80;
        $this->deleteFiles($json);

        $this->progressPercentage = 100;
        $this->deleteUpdateFolder();
    }

    private function downloadAndExtractRepo()
    {
        $updateDir = $this->downloadAndExtractRepoFromZip($this->targetDir, $this->repoUrl);
        if ($updateDir === -1) {
            $this->updateLogger("Error opening ZIP", $this->progressPercentage);
            exit(401);
        } elseif ($updateDir === -2) {
            $this->updateLogger("Error downloading ZIP", $this->progressPercentage);
            exit(401);
        }

        $this->updateDir = $this->targetDir . "/" . $updateDir;
        $this->updateLogger("Repo extracted to: " . $this->updateDir, $this->progressPercentage);
    }

    private function compareDirectories()
    {
        $targetIterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->targetDir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        $fileInfo = [];
        $totalFiles = 0;

        foreach ($targetIterator as $targetFile) {
            $relativePath = str_replace('\\', '/', substr($targetFile->getPathname(), strlen($this->targetDir) + 1));
            if ($this->shouldIgnore($relativePath)) {
                continue;
            }

            $updatePath = $this->updateDir . '/' . $relativePath;
            $isDeleted = !file_exists($updatePath);

            $isInAssets = str_starts_with($relativePath, 'assets/');
            $isInOverwriteableSubfolders = preg_match('#^assets/(css|js|htmlext)/#', $relativePath);

            if ($isInAssets && !$isInOverwriteableSubfolders) {
                if (!$isDeleted && !file_exists($targetFile->getPathname())) {
                    $fileInfo[] = [
                        'targetPath' => str_replace('\\', '/', $targetFile->getPathname()),
                        'updatePath' => str_replace('\\', '/', $updatePath),
                        'deleted' => $isDeleted,
                        'isDir' => $targetFile->isDir()
                    ];
                }
            } else {
                $fileInfo[] = [
                    'targetPath' => str_replace('\\', '/', $targetFile->getPathname()),
                    'updatePath' => str_replace('\\', '/', $updatePath),
                    'deleted' => $isDeleted,
                    'isDir' => $targetFile->isDir()
                ];
            }

            $totalFiles++;
            flush();
        }

        return json_encode($fileInfo, JSON_PRETTY_PRINT);
    }

    private function updateFiles($json)
    {
        $fileInfo = json_decode($json, true);
        $totalFiles = count($fileInfo);
        $processedFiles = 0;

        foreach ($fileInfo as $file) {
            if ($file['deleted']) {
                continue;
            }

            if ($file['isDir']) {
                if (!file_exists($file['targetPath'])) {
                    if (mkdir($file['targetPath'], 0777, true)) {
                        $this->updateLogger("Directory created: " . $file['targetPath'], $this->progressPercentage + ($processedFiles / $totalFiles * 20));
                    } else {
                        $this->updateLogger("Error creating directory: " . $file['targetPath'], $this->progressPercentage + ($processedFiles / $totalFiles * 20));
                    }
                }
                continue;
            }

            if (file_exists($file['updatePath'])) {
                if (file_put_contents($file['targetPath'], file_get_contents($file['updatePath'])) !== false) {
                    $this->updateLogger("File updated: " . $file['targetPath'], $this->progressPercentage + ($processedFiles / $totalFiles * 20));
                } else {
                    $this->updateLogger("Error updating file: " . $file['targetPath'], $this->progressPercentage + ($processedFiles / $totalFiles * 20));
                }
            } else {
                $this->updateLogger("Update file not found: " . $file['updatePath'], $this->progressPercentage + ($processedFiles / $totalFiles * 20));
            }

            $processedFiles++;
            flush();
        }
    }

    private function deleteFiles($json)
    {
        $fileInfo = json_decode($json, true);
        $totalFiles = count($fileInfo);
        $processedFiles = 0;

        foreach ($fileInfo as $file) {
            if (!$file['deleted']) {
                continue;
            }

            if (file_exists($file['targetPath'])) {
                if ($file['isDir']) {
                    if (rmdir($file['targetPath'])) {
                        $this->updateLogger("Directory removed: " . $file['targetPath'], $this->progressPercentage + ($processedFiles / $totalFiles * 20));
                    } else {
                        $this->updateLogger("Error removing directory: " . $file['targetPath'], $this->progressPercentage + ($processedFiles / $totalFiles * 20));
                    }
                } else {
                    if (unlink($file['targetPath'])) {
                        $this->updateLogger("File removed: " . $file['targetPath'], $this->progressPercentage + ($processedFiles / $totalFiles * 20));
                    } else {
                        $this->updateLogger("Error removing file: " . $file['targetPath'], $this->progressPercentage + ($processedFiles / $totalFiles * 20));
                    }
                }
            } else {
                $this->updateLogger("File not found for removal: " . $file['targetPath'], $this->progressPercentage + ($processedFiles / $totalFiles * 20));
            }

            $processedFiles++;
            flush();
        }
    }

    private function shouldIgnore($relativePath)
    {
        if ($relativePath === 'gdps_settings.json') {
            return true;
        }

        if (str_starts_with($relativePath, 'customfiles/')) {
            return true;
        }

        if (str_starts_with($relativePath, $this->getRelativePath($this->updateDir))) {
            return true;
        }

        if (str_starts_with($relativePath, 'update/')) {
            $filesToIgnore = ['log.txt', 'version.txt'];
            if (in_array(basename($relativePath), $filesToIgnore)) {
                return true;
            }
        }

        return false;
    }

    private function getRelativePath($path)
    {
        return str_replace('\\', '/', rtrim($path, '/')) . '/';
    }

    private function updateLogger($data, $percentage)
    {
        file_put_contents($this->fileLogger, strval($data . "|" . $percentage) . PHP_EOL, FILE_APPEND);
        echo $data . PHP_EOL;
        flush();
    }

    private function downloadAndExtractRepoFromZip($targetDir, $repoUrl)
    {
        $zipFile = 'ogdbrowser_sourcecode.zip';
        file_put_contents($zipFile, fopen($repoUrl, 'r'));
        if (file_exists($zipFile)) {
            $zip = new ZipArchive;
            if ($zip->open($zipFile) === TRUE) {
                $zip->extractTo($targetDir);
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

    private function deleteUpdateFolder()
    {
        $this->deleteDirectoryContents($this->updateDir);

        if (rmdir($this->updateDir)) {
            $this->updateLogger("Update directory removed: " . $this->updateDir, 100);
        } else {
            $this->updateLogger("Error removing update directory: " . $this->updateDir, 100);
        }

        $installerFile = $this->targetDir . "/installer.php";
        if (file_exists($installerFile)) {
            unlink($installerFile);
        }
    }

    private function deleteDirectoryContents($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->deleteDirectoryContents("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
}


/* -------------- Main ----------------- */

$lru_ogdb = null;
$version_ogdb = null;
$date_ogdb = null;


function getLatestReleaseUrl() {
    $url = "https://api.github.com/repos/migmatos/ObeyGDBrowser/releases/latest";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['User-Agent: PHP']);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
    if (isset($data['tag_name'])) {
        return [$data['tag_name'],$data['created_at']];
    } else {
        return false;
    }
}

if ($error_installer || !isset($_POST["lru"]) ) {
    $result = getLatestReleaseUrl();
    if ($result == false) {
        http_response_code(401);
        exit("Deprecated method: An error occurred while fetching the update.");
    }
    list($tagName, $createdAt) = $result;
    $lru_ogdb = "https://codeload.github.com/MigMatos/ObeyGDBrowser/zip/refs/tags/" . $tagName; /* Download from Github */
    $date_ogdb = $createdAt;
    $version_ogdb = $tagName;
} else if(isset($_POST['lru']) && isset($_POST['ver']) && isset($_POST['date'])) {
    
    function isOfficialGitHubLink($url) {
        $pattern = '/^https:\/\/([\w-]+\.)*github\.com(\/.*)?$/';
        return preg_match($pattern, $url);
    }

    $lru_ogdb = $_POST['lru'];
    $version_ogdb = $_POST['ver'];
    $date_ogdb = $_POST['date'];

    if (!isOfficialGitHubLink($lru_ogdb)) {
        http_response_code(401);
        exit("Error: This URL is not official from Github.");
    }
    
} else {
    http_response_code(401);
    exit("Error: {{lru|ver|date}} was not provided to the updater.");
}

/* VARIABLES */

$folder_browser = "browser/";

/* RUN UPDATER */

$updater = new OGDBrowserUpdater($folder_browser, $lru_ogdb);
$updater->run();

/* FINISHING */

$version_file_path = "./" . $folder_browser . 'update/version.txt';
file_put_contents($version_file_path , $version_ogdb . "|" . $date_ogdb);



?>