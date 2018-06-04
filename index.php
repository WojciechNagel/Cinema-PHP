<?php
$db = new PDO('sqlite:cinema.db');
session_start();
if(!isset($_SESSION['page'])){
  $_SESSION['page'] = 'seans';
}

if(isset($_GET['id_seans'])){
  $_SESSION['page'] = 'room';
}
elseif(isset($_POST['go'])){
  $_SESSION['page'] = 'res';
}

else{
  $_SESSION['page'] = 'seans';
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8' />
        <title>Kino</title>
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
           if(isset($_SESSION['page'])){
             $page = $_SESSION['page'];
             if ($page == "seans"){
               include 'seans_list.php';
             }
             elseif($page == "room"){
               include 'room.php';
             }
             elseif($page == "res"){
               include 'reservation.php';
             }
           }
         ?>
    </div>
  </div>
  <div id="bottom">
    <?php
    if ($page == "seans"){
      print '<a href="admin_index.php">Przejdź do panelu admina</a>';
    }
    ?>
  </div>
</div>
</body>
</html>
