<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ObeyGDBrowser Installer</title>
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://migmatos.alwaysdata.net/legacy/cdn/css/dashboard.css" />
</head>
<style>
    .songscontent {
        border: 3px solid transparent;
    }

    .dashboard-container.gdbox-brown.songs {
        margin-top: 1%;
        margin-left: calc(5vw + (10vw / 1000));
        margin-right: calc(5vw + (10vw / 1000));
        margin-bottom: 1%;
    }

</style>
<body>

<link rel="stylesheet" href="https://migmatos.alwaysdata.net/legacy/cdn/css/utils.css">
<link rel="stylesheet" href="https://migmatos.alwaysdata.net/legacy/cdn/css/flayers.css?v=8">
  <div class="over-flalert" id="gd-fancy-box">
    
    <div class="gdalert fancy-box">
      <div class="flayercontent">
        <p class="font-gold-pusab" id="fllayertitle-fancy">TEST ALERT</p>
        <p class="font-helvetica" id="fllayerdesc-fancy">TEST ALERT 123</p>
        <div class="flayeroptions-fancy" id="options-fl-layer-fancy"></div>
        <button class="gdbtn-close fancy-0" id="gdclose-fancy-btn"></button>
      </div>
    </div>
  </div>
  <div class="over-flalert" id="gd-brown-box">
    <div class="gdalert brown-box">
      <div class="flayercontent">
        <p class="font-gold-pusab" id="fllayertitle-brown">TEST ALERT</p>
        <p class="font-helvetica" id="fllayerdesc-brown">TEST ALERT 123</p>
        <img src="https://migmatos.alwaysdata.net/legacy/cdn/icons/loading.png" alt="Loading" class="fllayeriframe-brown-rotating-img" id="fllayeriframe-brown-rotating-img">
        <iframe class="iframe-brown" id="fllayeriframe-brown" src="" frameborder="0"></iframe>
        <button class="gdbtn-close brown-0" id="gdclose-brown-btn"></button>
      </div>
    </div>
  </div>
<script src="https://migmatos.alwaysdata.net/legacy/cdn/js/utils.js?v=4"></script>
<script src="https://migmatos.alwaysdata.net/legacy/cdn/js/securityParser.js?v=8"></script>
<script src="https://migmatos.alwaysdata.net/legacy/cdn/js/flayers.js?v=10"></script>

<link rel="stylesheet" href="https://migmatos.alwaysdata.net/legacy/cdn/css/loadingalert.css?v=6">
<div class="loading-main" id="loading-main">
    <div class="rotating-loadermain-image">
      <img src="https://migmatos.alwaysdata.net/legacy/cdn/icons/loading.png" alt="Loading" id="rotating-img">
    </div>
</div>
<div class="loading-alert-buttom-display" id="loading-alert-buttom-display">
  <div class="rotating-loadermain-image">
    <img src="https://migmatos.alwaysdata.net/legacy/cdn/icons/loading.png" alt="Loading" id="rotating-img">
    <p class="gdfont-Pusab small" id="loading-alert-buttom-display-text">Loading...</p>
  </div>
</div>
<script src="https://migmatos.alwaysdata.net/legacy/cdn/js/loadingalert.js?v=4"></script>


<div class="dashboard-container gdbox-brown songs">
    <h1 class="gdfont-Pusab normal">ObeyGDBrowser Installer</h1>
    <label class="gdfont-Pusab small">Log into an administrator account in that gdps database to install. (MODERATORS NO ALLOWED) <span style="color:red;">(Unstable version)</span></label>
    <?php
	
    $path_conn = "./incl/lib/";

    $connection_path = $path_conn."connection.php";
    $generate_pass_path = $path_conn."generatePass.php";
    $conn_exist = false;


    if (file_exists($connection_path) && file_exists($generate_pass_path)) {
        require $connection_path;
        require $generate_pass_path;
        $conn_exist = true;
    } else {
        if (isset($_POST['conn'])){

            $connection_path = $_POST['conn']."connection.php";
            $generate_pass_path = $_POST['conn']."generatePass.php";

            if (file_exists($connection_path) && file_exists($generate_pass_path)) {
                require $connection_path;
                require $generate_pass_path;
                $conn_exist = true;
            }
            else {
                $_GET["alert"] = 4;
            }

        } 
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

    function downloadAndExtractRepo($repoUrl) {
        $zipFile = 'repo.zip';
        file_put_contents($zipFile, fopen($repoUrl, 'r'));
        if (file_exists($zipFile)) {
            $zip = new ZipArchive;
            if ($zip->open($zipFile) === TRUE) {
                $zip->extractTo('./browser/');
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
        $sourceDir = "browser/" . rtrim($sourceDir, '/');
        $destinationDir = './browser/';
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
        rmdir("./".$sourceDir);
        return true;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && $conn_exist) {
        $owner = 'MigMatos';
        $repo = 'ObeyGDBrowser';


        $flw = "./browser";

        if (isset($_POST['userName']) && isset($_POST['password'])) {
            $userName = $_POST['userName'];
            $password = $_POST['password'];


            $pass = GeneratePass::isValidUsrname($userName, $password);

            if ($pass == "1") {


                $stmt = $db->prepare("SELECT accountID, isAdmin FROM accounts WHERE userName LIKE :userName");
                $stmt->bindParam(':userName', $userName);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);


                if ($result['isAdmin'] == "1") {


                    $latesttag = getLatestReleaseUrl($owner, $repo);
                    
                    
                    mkdir($flw, 0777, true) ?? rmdir($$flw) && mkdir($flw, 0777, true);


                    if ($latesttag) {

                        echo "<script>";
                        echo 'changeLoadingAlert("Installing...");';
                        echo "</script>";
                        $dir = "https://codeload.github.com/MigMatos/ObeyGDBrowser/zip/refs/tags/$latesttag";
                        $dir = downloadAndExtractRepo($dir);

                        moveFilesToCurrentDirectory("./" . $dir);

                        $version_file_path = "./browser/update/version.txt";
                        file_put_contents($version_file_path , "" . $latesttag);


                        unlink("./installer.php");
                        unlink("./README.md");
                        unlink("./browser/installer.php");
                        header("Location: ./browser/?alert=installed");
                        exit();

                    } else {
                        header("Location: ./installer.php?alert=1");
                    }
                } else {
                    header("Location: ./installer.php?alert=2");
                }
            } else {
                header("Location: ./installer.php?alert=3");
            }
        }
    } else {
    
	
	if ( isset($_GET["alert"] ) ) {
		$num = $_GET["alert"];
		if($num == 1){
			echo '<script>CreateFLAlert("Error","`r0 Failed to get installation` \n Report in ObeyGDBrowser Support Server: [![Geometry Dash](https://invidget.switchblade.xyz/EbYKSHh95B)](https://discord.gg/EbYKSHh95B)");</script>';
		}
		elseif ($num == 2){
			echo '<script>CreateFLAlert("Error","`r0 You are not an administrator in that GDPS` \n You need to be an **administrator account** in that GDPS to continue with the installation, if you need help join our Discord Support Server: [![Geometry Dash](https://invidget.switchblade.xyz/EbYKSHh95B)](https://discord.gg/EbYKSHh95B)");</script>';
		}
		elseif ($num == 3){
			echo '<script>CreateFLAlert("Error","`r0 Error, your password or username is wrong...`");</script>';
		}
        elseif ($num == 4){
			echo '<script>CreateFLAlert("Error","`r0 Connection folder not found...` \n\n If you need help join our Discord Support Server: [![Geometry Dash](https://invidget.switchblade.xyz/EbYKSHh95B)](https://discord.gg/EbYKSHh95B)");</script>';
		}
		
	}
	
	}
	
	?>
	<br><br><br>
	
	
	
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<div>
			<label class="gdfont-Pusab small" for="userName">UserName:</label><br>
			<input  class="gdInput text" type="text" id="userName" name="userName" required>
		</div>
		<div>
			<label class="gdfont-Pusab small" for="password">Password:</label><br>
			<input class="gdInput text" type="password" id="password" name="password" required>
		</div>

        <?php if (!$conn_exist) { ?>

        <div>
			<label class="gdfont-Pusab small" for="conn">GDPS Connection Folder (lib):</label><br>
			<input class="gdInput text" type="text" id="conn" name="conn" value="../incl/lib/" required>
		</div>

        <?php } ?>


		<br>
        <button class="gdButton" type="submit" onclick="submitForm()"><label class="gdfont-Pusab small">Install</label></button>
    </form>
	<br><br>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
        $("#loading-main").hide();
		
		if ((window.location.search == "?alert=1") || (window.location.search == "?alert=2" ||(window.location.search == "?alert=3") || (window.location.search == "?alert=4"))) {
		let newURLpush = window.location.href.replace(/(\?alert=1|\?alert=2|\?alert=3|\?alert=4)/g, '');
		window.history.pushState(null, null, newURLpush);
		}
		
		function submitForm(){
            const userName = $("#userName").val().trim();
            const password = $("#password").val().trim();

            // Verificar si los campos no están vacíos
            if (userName !== "" && password !== "") {
                $("#loading-main").show();
                const event = new Event('initLoadingAlert');
                document.dispatchEvent(event);
                changeLoadingAlert("Loading...");
            }
		}
		
</script>
</html>
