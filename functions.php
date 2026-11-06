<?php
    function dbConnect($localhost,$dbname,$username,$password){
        $dsn = "mysql:host=$localhost;dbname=$dbname";
        try{
            $db = new PDO($dsn,$username,$password);
            return $db;
        }catch(PDOException $e){
            echo "<script>alert('please try in another time')</script>" ;    
        }

        
    }

    function p($arr){
        echo "<pre>";
            print_r($arr);
        echo "</pre>";
    }

    function searchInDB($db,$column,$table,$wordSearch){
        $query = "select $column from $table where $column = :wordSearch";
        $stmt = $db -> prepare($query);
        $stmt -> execute([":wordSearch" => $wordSearch]);
        return $stmt->fetch();
    }

    function PwdIstrouve($db,$table,$email,$pwd){
        $query = "select id_user,nom,pwd from $table where email = :email";
        $stmt = $db -> prepare($query);
        $stmt-> execute([":email" => $email]);
        $infos_user = $stmt -> fetch();
        return ($pwd && password_verify($pwd,$infos_user["pwd"]))? $infos_user  : false; 
    }

    function insertUser($db,$fname,$lname,$email,$password){

            $query = "insert into users(nom,prenom,email,pwd) values(:fname,:lname,:email,:pwd)";
            $stmt2 = $db -> prepare($query) ;

            $stmt2 -> execute([
                                ":fname" => $fname,
                                ":lname" => $lname,
                                ":email" => $email,
                                ":pwd" => $password
                             ]);
    }

?>