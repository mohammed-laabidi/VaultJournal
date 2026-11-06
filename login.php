<?php
    require "functions.php";

    if(isset($_POST["Login"])){
        if(!empty($_POST["email"]) && !empty($_POST["password"])){
            //connect with DB
            $db = dbConnect("localhost","journal_db","root","");

            if($db){
                $loginSuccess = false;
                // check if username and password are in DB
                // pwdIstrouve return array qui contient pwd ,nom et id user
                $pwdIsTrouve = PwdIstrouve($db,"users",$_POST["email"],$_POST["password"]);
                $emaiIsTrouve = searchInDB($db,"email","users",$_POST["email"]);

                if($pwdIsTrouve && $emaiIsTrouve){
                    session_start();
                    $_SESSION["infos_user"] = $pwdIsTrouve;
                    $loginSuccess = true;
                    header("location: journal.php ");
                    exit();
                }
                
            }
        }else{
            echo "<script>alert('please entre Username and Password')</script>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Login</title>
</head>

<body>
    <div class="box_login">
        <h1>Login</h1>
        <p id="msgErr" style="display:none">Username or Password is False</p>
        <?php if(isset($_POST["Login"]) && isset($loginSuccess) && !$loginSuccess):?>
            <p id="msgErr">Username or Password is False</p>
        <?php endif?>
        <form action="" method="POST">
            <input type="email" name="email" placeholder="email">
            <input type="password" name="password" placeholder="password">
            <button type="submit" name="Login">Login</button>
        </form>

        <div class="links">
            <a href="forgetPassword.php">forget Password</a>
            <a href="register.php">register</a>
        </div>
    </div>
</body>
</html>

