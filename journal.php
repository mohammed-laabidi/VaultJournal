<?php
    session_start();
    if(!isset($_SESSION["infos_user"])) header("location: login.php");
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Journal</title>
    <link rel="stylesheet" href="css/journal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <h1>Personal Journal</h1>
        <button class="btnNew" onclick="showNewEntryForm()"> + New Entry</button>
    </header>

    <div class="container">
        <div id="box_search">
            <input type="search" name="inpSearch" id="inpSearch" placeholder="Search..." readonly>
            <button id="SearchByT" onclick="ChoisirModeSearch(this.id)">Search By Title</button>
            <button id="SearchByD" onclick="ChoisirModeSearch(this.id)">Search By date</button>
        </div>
        
        <div id="entries">
            
        </div>

        <div id="box_newEntry">
                <input type="text" name="title" id="inpTitle" placeholder="Write title the Entry">
                <textarea name="description" id="description" placeholder="Write your Entry..."></textarea>
                <div id="box_btns">
                    <button id="btnClose">Close</button>
                    <button id="btnSave">Save</button>
                </div>
        </div>

        
    </div>

    <script src="JS/script.js"></script>
</body>
</html>