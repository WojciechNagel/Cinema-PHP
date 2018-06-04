<?php
$db = new PDO('sqlite:cinema.db');
session_start();
if(!isset($_SESSION['vaild'])){
  $_SESSION['vaild'] = 'false';
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8' />
        <title>Kino - panel admina</title>
        <link rel="stylesheet" href="style.css"/>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
      

    </head>
<body>

<div id="container">
  <div id="top">
      <a href="index.php"><img src="img/logo.png" alt="Kino Miejskie"/></a>

  </div>
  <div id="body">
    <div id="header">
      <?php
           if(isset($_SESSION['vaild'])){
             $page = $_SESSION['vaild'];
             if ($page == "false"){

              include 'login.php';
             }
             elseif($page == "true"){
               include 'add_movie.php';
           }
         }
         ?>
    </div>
  </div>
  <div id="bottom">

  </div>
</div>
</body>
</html>
