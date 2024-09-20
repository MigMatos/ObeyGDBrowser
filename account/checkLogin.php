<?php

include "../_init_.php";

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

            //header("Location: ../../");
            exit();
            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            die();
        }
    } else {

        echo "Invalid user or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body bgcolor="#999999">

<h2>Login</h2>
<fieldset>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div>
        <label for="userName">UserName:</label><br>
        <input type="text" id="userName" name="userName" required>
    </div>
    <div>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required>
    </div>
    <br>
    <div>
        <button type="submit">Login</button>
        <button type="button" onclick="window.location.href = '../';">Back</button>
    </div>
</form>
</fieldset>

</body>
</html>
