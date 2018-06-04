<?php

if(!isset($_SESSION['vaild'])){
  $_SESSION['vaild'] = 'false';
}
$visible="false";
$db = new PDO('sqlite:cinema.db');


  if(isset($_POST['login']) && isset($_POST['password'])){
  $login = $_POST['login'];
  $password = $_POST['password'];
  $password=md5($password);

  $check_credentials=($db->query("select login, password from users"))->fetch();

  if($check_credentials['login'] == $login && $check_credentials['password'] == $password){
    $_SESSION['vaild'] = 'true';
    include 'add_movie.php';


  }
  else {
    $_SESSION['vaild'] = 'false';
    print' <form action="admin_index.php" method="POST">
       Login: <br /> <input type="text" name="login" /> <br />
       Password: <br /><input type="password" name="password" /> <br /><br />
       <input type="submit" value="Zaloguj!" />
     </form>';


  }
}
  else {
    print' <form action="admin_index.php" method="POST">
       Login: <br /> <input type="text" name="login" /> <br />
       Password: <br /><input type="password" name="password" /> <br /><br />
       <input type="submit" value="Zaloguj!" />
     </form>';
  }




?>
