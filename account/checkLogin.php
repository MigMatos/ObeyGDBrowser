<?php

include "../_init_.php";
include("../assets/htmlext/flayeralert.php");

$includeFile = "../".$includeFolder."generatePass.php";

// Verificar si el archivo existe
if (file_exists($includeFile)) {
    require $includeFile;
} else {
    $includeFile = $includeFolder."generatePass.php";
    if (file_exists($includeFile)) {
        require $includeFile;
    } else {
        echo "Error, missing File: generatePass.php";
        exit();
    }
}


if(isset($_POST['userName']) && isset($_POST['password'])) {
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    

    $pass = GeneratePass::isValidUsrname($userName, $password);

    if($pass == "1") {
        try {

            include("../api/profile.php");
            include("../api/roles.php");

            $params = ["username" => $userName];
            $response = profileUsers($params, $db, $gdps_settings);
            $result = json_decode($response, true);
            $result = $result[0];
            

            $_SESSION['userName'] = $result['username'];
            $_SESSION['userID'] = $result['playerID'];
            $_SESSION['accountID'] = $result['accountID'];

            $params = ["accountid" => 1];
            $response = getRoles($params, $db, $gdps_settings);
            $resultroles = json_decode($response, true);

            $_SESSION['isAdmin'] = $resultroles['user']['isAdmin'] ?? $result['admin'];
            updateUserPerms($resultroles['permissions'] ?? []);

            header("Location: ?success=1");
            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            die();
        }
    } else if ($pass == "0") {
        header("Location: ?error=1");
    } else if ($pass == "-1") {
        header("Location: ?error=2");
    } else if ($pass == "-2") {
        header("Location: ?error=3");
    } else {
        header("Location: ?error=0");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="../assets/css/browser.css?v=6" type="text/css" rel="stylesheet">
    
</head>
<body style="background: unset; background-color: transparent; width: 100%; height: 100%;">


<div class="brownBox center supercenter" style="width: 135vh; height: 82%; margin-top: -0.7%">
    <h2>Login</h2>
    <div><h3 id="alertLoginError" style="display: none; color: #ff6e6e; margin: 1vh 20vh 0vh 20vh; padding: 1vh; border-radius: 2vh; background-color: #0000005c;">Username or password is incorrect.</h3></div>
    <div><h3 id="alertIPError" style="display: none; color: #ff6e6e; margin: 1vh 10vh 0vh 10vh; padding: 1vh; border-radius: 2vh; background-color: #0000005c;">Too many attempts, account temporarily blocked from this IP.</h3></div>
    <div><h3 id="alertAccountError" style="display: none; color: #ff6e6e; margin: 1vh 20vh 0vh 20vh; padding: 1vh; border-radius: 2vh; background-color: #0000005c;">Account disabled or unactivated.</h3></div>
    <div><h3 id="alertUnknownError" style="display: none; color: #ff6e6e; margin: 1vh 20vh 0vh 20vh; padding: 1vh; border-radius: 2vh; background-color: #0000005c;">Unknown Error in Login.</h3></div>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="loginForm">

        <div style="margin-top: 2vh;">
            <h3 for="userName">Username:</h3><br>
            <input type="text" id="userName" name="userName" style="height: 8%;" required>
        </div>
        <div style="margin-top: 2vh;">
            <h3 for="password">Password:</h3><br>
            <input type="password" id="password" name="password" style="height: 8%;" required>
        </div>
        <br>
        <div style="display: flex; justify-content: center;">
        <div class="gdsButton" onclick="let form = document.getElementById('loginForm'); form.checkValidity() ? form.submit() : form.reportValidity(); return false;" style="padding-left:1.5vh;padding-right:1.5vh;margin-right: 3vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect">Login</h3></div>
        <div class="gdsButton red" onclick="closeMessageCustomFrame();" style="padding-left:1.5vh;padding-right:1.5vh;margin-right: 3vh;height: 5vh; padding-top: 0.8vh;"><h3 class="gdfont-Pusab" style="align-items: center;" id="textContentFileSelect">Exit</h3></div>

        </div>
    </form>
</div>

</body>
<script type="text/javascript" src="../misc/gdcustomframe.js"></script>
<script>
if (window.location.search.includes("error=1")) {
    document.getElementById('alertLoginError').style.display = 'block';
} else if (window.location.search.includes("error=2")) {
    document.getElementById('alertIPError').style.display = 'block';
} else if (window.location.search.includes("error=3")) {
    document.getElementById('alertAccountError').style.display = 'block';
} else if (window.location.search.includes("error=0")) {
    document.getElementById('alertUnknownError').style.display = 'block';
}
 else if (window.location.search.includes("success=1")) {
    document.getElementById('alertLoginError').style.display = 'none';
    closeandrestartMessageCustomFrame();
}
</script>

</html>
