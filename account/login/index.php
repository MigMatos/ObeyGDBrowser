<?php

include "../../_init_.php";
require "../".$includeFolder."generatePass.php";



if($logged){
    header("Location: ../");
    exit();
}


if(isset($_POST['userName']) && isset($_POST['password'])) {
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    

    $pass = GeneratePass::isValidUsrname($userName, $password);

    if($pass == "1") {
        try {

            $stmt = $db->prepare("SELECT accountID, isAdmin FROM accounts WHERE userName LIKE :userName");
            $stmt->bindParam(':userName', $userName);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            

            $_SESSION['userName'] = $userName;
            $_SESSION['accountID'] = $result['accountID'];
            $_SESSION['isAdmin'] = $result['isAdmin'];
            

            header("Location: ../../");
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
        <button type="button" onclick="window.location.href = '../../';">Back</button>
    </div>
</form>
</fieldset>

</body>
</html>
