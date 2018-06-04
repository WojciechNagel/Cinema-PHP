<div id="confirm_wrapper">
  <?php
    if(isset($_POST['id_seans'])) {
      $id_seans = $_POST['id_seans'];
    }

    if(isset($_POST['s']) && isset($_POST['name']) && isset($_POST['email'])) {
      $name = $_POST['name'];
      $email = $_POST['email'];

      $dobrze = true;
      $flaga = true;
        if(!preg_match('/^[a-ząęźżśóćńłA-ZAĘŹŻŚÓĆŃŁ]* [a-ząęźżśóćńłA-ZAĘŹŻŚÓĆŃŁ]*$/', $name)) {$dobrze = false;}
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {$dobrze = false;}


      //weryfikacja dostępności miejsc

        foreach ($_POST['s'] as $c) {
          $seat = explode("v",$c);
          $seat_check = ($db->query("SELECT row, seat FROM reservations WHERE id_seans=$id_seans AND row=$seat[0] AND seat=$seat[1]"))->fetch();
            if($seat_check != NULL){
              $flaga = false;
            }
        }

        if($flaga == true && $dobrze == true) {
          $a = ($db->query("SELECT number FROM reservations ORDER BY id_res DESC LIMIT 1"))->fetch();
            if($a == NULL) {
              $a[0] = 1;
            }
            else{
              $a[0] += 1;
            }

          print '<div id="confirm_header">Twój numer rezerwacji: #'.$a[0].' </div>';
          print '<div id="confirm_body">';
            foreach($_POST['s'] as $c){
              $seat = explode("v",$c);
              print 'Rząd: <b>'.$seat[0].'</b> Miejsce: <b>'.$seat[1]. '</b></br>';
              $array = ($db->query("SELECT id_res FROM reservations ORDER BY id_res DESC LIMIT 1"))->fetch();
                if($array == NULL){
                  $array[0] = 1;
                }
                else{
                  $array[0] += 1;
                }
              //$array[0] += 1;
              $date = date("Y-m-d H:i:s");
              $zap = "INSERT INTO reservations(id_res, id_seans, row, seat, time_res, number, name, email) VALUES(:id_res, :id_seans, :row, :seat, :time_res, :number, :name, :email)";
              $res = $db->prepare($zap);
              $res->bindValue(':id_res', $array[0]);
              $res->bindValue(':id_seans', $id_seans);
              $res->bindValue(':row', $seat[0]);
              $res->bindValue(':seat', $seat[1]);
              $res->bindValue(':time_res', $date);
              $res->bindValue(':number', $a[0]);
              $res->bindValue(':name', $name);
              $res->bindValue(':email', $email);
              $res->execute();
            }
          print '</br>';
          print 'Imie i nazwisko: <b>'.$name.'</b></br>';
          print 'E-mail: <b>'.$email.'</b></br>';

          print '</div>';
          print '<div id="confirm_footer"><a href="index.php" class="button">STRONA GŁÓWNA</a></div>';
        }
        else {
          if($dobrze == false){ print '<p class="error">Błednia wypełniony formularz!</p>'; }
          if($flaga == false){ print '<p class="error">Wybrane miejsca nie są już dostępne!</p>'; }


          print '<p class="info">Aby wrócić do formularza rezerwacji - <u><a href="index.php?id_seans='.$id_seans.'" title="kliknij, aby wrócić">kliknij tutaj...</a></u></p>';
        }
    }
    else {
      print '<p class="error">Błąd! Nie zaznaczyłeś/aś miejsc!</p>';
      print '<p class="info">Aby wrócić do formularza rezerwacji - <u><a href="index.php?id_seans='.$id_seans.'" title="kliknij, aby wrócić">kliknij tutaj...</a></u></p>';
    }
  ?>
</div>
