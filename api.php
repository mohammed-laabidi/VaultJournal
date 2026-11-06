<?php
    session_start();
    if(!isset($_SESSION["infos_user"])){
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "Please login first!"]);
        exit;
    }

    header('Content-Type: application/json; charset=utf-8');

    function dbConnect(){
        try{
            $db = new PDO("mysql:host=localhost;dbname=journal_db","root","");
            return $db;
        }catch (Exception $e) {
        
            http_response_code(500); 

            echo json_encode([
                "status" => "error",
                "message" => "please try in another time"
            ]);
            
        }
    };

    function getEntriesByidUser($idUser){
        $db = dbConnect();

        if($db){

            $q = "select * from entries where id_user = :id";
        
            $stmt = $db -> prepare($q);
            $stmt -> execute([":id" => $idUser]);



            return json_encode($stmt -> fetchAll());
            
        }
       

    }

    function setEntryByIdUser($idUser,$title,$description){
        $db = dbConnect();
        if($db){
            
            $q = "insert into entries(title,description,id_user) values(:title,:description,:idUser)";

            $stmt = $db -> prepare($q);

            $stmt -> execute([
                ":title" => $title,
                ":description" => $description,
                ":idUser" => $idUser,
            ]);

          
            
           
        }


    }

    function deleteEntryByIdEntry($idEntry){
        $db = dbConnect();

        $q = "delete from entries where id = :idEntry";

        $stmt = $db -> prepare($q);

        $stmt -> execute(["idEntry" => $idEntry]);
    }

    function UpdateEntryByIdEntry($idEntry,$title,$description){
        $db = dbConnect();


        $q = "update entries 
              set title = :title, 
              description = :description,
              date_creation = NOW()
              where id = :id";

        $stmt = $db -> prepare($q);

        $stmt -> execute([
            ":title" => $title,
            ":description" => $description,
            ":id" => $idEntry
        ]);
        
    }

    $id_User = $_SESSION["infos_user"]["id_user"];

    if($_GET["action"] === "show")   echo getEntriesByidUser($id_User);

    else if($_GET["action"] === "add" 
            && isset($_GET["title"])
            && isset($_GET["description"])
            ) {
                setEntryByIdUser($id_User,$_GET["title"],$_GET["description"]);

    }else if($_GET["action"] === "delete" && isset($_GET["idEntry"])){
        deleteEntryByIdEntry($_GET["idEntry"]);

    }else if($_GET["action"] === "update" && 
        isset($_GET["idEntry"]) && 
        isset($_GET["newTitle"]) && 
        isset($_GET["newDescription"])
    ){
        UpdateEntryByIdEntry($_GET["idEntry"],$_GET["newTitle"],$_GET["newDescription"]);
       
    }
        

?>