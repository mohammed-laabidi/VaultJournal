<?php
        require "functions.php";


        if(isset($_POST["register"])){
            if(
                !empty($_POST["fname"])
                && !empty($_POST["lname"])
                && !empty($_POST["email"])
                && !empty($_POST["password"])
            ){
                //connection à database
                $db = dbConnect("localhost","journal_db","root","");

                if($db){
                     
                    // supprimer les espaces
                    $fname = str_replace(" ", "", $_POST["fname"]);
                    $lname = str_replace(" ", "", $_POST["lname"]);
                    $email = str_replace(" ", "", $_POST["email"]);

                    //decrypte password 
                    $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
                    
                    //check email il est déja exist or no 
                    $emailSearch = searchInDB($db,"email","users",$email);

                    $ajouterUser = false;

                    if(!$emailSearch){
                        insertUser($db,$fname,$lname,$email,$password);
                        $ajouterUser = true;
                    }
                }
                
               
            
            }else echo "<script>alert('please fill all inputs')</script>";
        };
       

    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Register</title>
</head>

<body>
    <div class="box_login">
        <h1>register</h1>
        <?php if(isset($_POST["register"])): 

                if(isset($emailSearch) && !empty($emailSearch)) :?>
                    <p id="msgErr">this email il est déja exist</p>
                <?php endif?>
                    
                <?php if(isset($ajouterUser) && !empty($ajouterUser)): header("Refresh: 3; url=login.php");?>
                    <p id="msgSuccess">register is successufull</p>
                 <?php endif?>

        <?php endif?>

        <form action="" method="POST">
            <input type="text" name="fname" placeholder="First Name" require>
            <input type="text" name="lname" placeholder="Last Name" require>
            <input type="email" name="email" placeholder="Email" require>
            <input type="password" name="password" placeholder="Password" require>
            <button type="submit" name="register">register</button>
        </form>

        <div class="links">
            <a href="forgetPassword.php">forget Password</a>
            <a href="login.php">login</a>
        </div>
    </div>

    
</body>
</html>

