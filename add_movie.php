<?php
if(!isset($_SESSION['vaild'])){
  $_SESSION['vaild'] = 'false';
}
if (($_SESSION['vaild']) == "true") {
  print 'Witaj w panelu admina - tutaj masz możliwosć dodania filmu: </br></br>
  <form action="'.$_SERVER['SCRIPT_NAME'].'" method="POST">
    <label>Tytuł: </label><input name="movie_title">

    <label>Dzień: </label>
          <select name="day">
      <option value="1">Poniedziałek</option>
      <option value="2">Wtorek</option>
      <option value="3">Środa</option>
      <option value="4">Czwartek</option>
      <option value="5">Piątek</option>
      <option value="6">Sobota</option>
      <option value="7">Niedziela</option>
          </select>
      <label>Godzina: </label>
          <select name="time">
      <option value="10:00">10:00</option>
      <option value="12:30">12:30</option>
      <option value="19:00">19:00</option>
      <option value="21:00">21:00</option>
          </select>

      <label>Sala: </label>
          <select name="sala">
      <option value="1">Sala 1</option>
      <option value="2">Sala 2</option>
      <option value="3">Sala 3</option>
          </select>
</br></br>
      <input id="submit" name="submit" type="submit" value="Wyślij">
   </form>';
$db = new PDO('sqlite:cinema.db');
  if(isset($_POST['movie_title']) && isset($_POST['day']) && isset($_POST['time']) && isset($_POST['sala']) && ($_POST['movie_title'] != "")) {
    $movie_title = $_POST['movie_title'];
    $day = $_POST['day'];
    $time = $_POST['time'];
    $sala = $_POST['sala'];


    $id=($db->query("select max(id_seans) from seanse"))->fetch();
    $id=$id[0]+1;


    #walidacja - czy jest już taki seans
    $sql = "SELECT title, day, time FROM seanse WHERE title=:title and day=:day and time=:time and id_room=:sala";

    $check_query = $db->prepare($sql);
    $check_query->bindValue(':title', $movie_title);
    $check_query->bindValue(':day', $day);
    $check_query->bindValue(':time', $time);
    $check_query->bindValue(':sala', $sala);
    $check_query->execute();

    $check_query = $check_query->fetch();

    if($check_query == NULL){
      $insert_sql = "INSERT INTO seanse(id_seans, title, day, time, id_room) VALUES(:id_seans, :title, :day, :time, :id_room)";
      $insert_sql = $db->prepare($insert_sql);
      $insert_sql->bindValue(':id_seans', $id[0]);
      $insert_sql->bindValue(':title', $movie_title);
      $insert_sql->bindValue(':day', $day);
      $insert_sql->bindValue(':time', $time);
      $insert_sql->bindValue(':id_room', $sala);
      $insert_sql->execute();

      $day_array = array(1=>'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela');
      print '<p class="info">Dodałeś seans: '.$movie_title.' , '.$day_array[$day].' , '.$time.' w sali: '.$sala.'</p>';

    }
    else {
      print '<p class="error">Seans już istnieje!</p>';

    }

  }
}
else {
  print '<p class="error">Dostep dla zalogowanych!</p>';

}
?>
