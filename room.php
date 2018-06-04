<?php
    //sprawdzanie poprawnosci pobranego linku $_GET
  $max = ($db->query("select max(id_seans) from seanse"))->fetch();
  if(isset($_GET['id_seans']) && (($_GET['id_seans']) > 0 && ($_GET['id_seans']) <= $max[0])){
    $id_seans = $_GET['id_seans'];
    $inf_query = ($db->query("select * from SEANSE where ID_SEANS = $id_seans"))->fetch();
    $s_query = ($db->query("select * from SALE where ID_ROOM = (select ID_ROOM from SEANSE where ID_SEANS = $id_seans)"))->fetch();
    $day = $inf_query['day'];
    $day_array = array(1=>'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela');
    $day_string = $day_array[$day];
?>
<div id="cont_sala">
  <div id="top_sala">
    <?php
    //info o seansie
    print 'Wybrany film: <b>'.$inf_query['title'].'</b> w sali: <b>'.$inf_query['id_room'].'</b>';
    print ' || <b>'.$day_string.'</b>';
    print ' <b>'.$inf_query['time'].'</b>';
    ?>
  </div>
  <div id="left_sala">
    <div id="t_left_sala"><img src="img/ekran_cz.png" alt="Ekran"/></div>
    <div id="m_left_sala">
      <?php
          print '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post"><input type="hidden" name="go" value="res"><input type="hidden" name="id_seans" value="'.$id_seans.'">';
          //petla wyswietlajaca miejsca
                for ($i = 1; $i <= $s_query['rows_number']; $i++){
                  for ($l = 1; $l <= $s_query['seats_per_row']; $l++){
                    $q = "SELECT id_res from reservations where row = $i and seat = $l and id_seans = $id_seans";
                    $qu = $db->query($q);
                    $qq = $qu->fetch();
                      if ($qq != NULL){

                        print '<input type="checkbox" id="'.$i.$l.'" name="s[]" value="'.$i.'v'.$l.'" disabled><label for="'.$i.$l.'"><span>'.$l.'</span></label>';
                          }
                          else{
                            print '<input type="checkbox" id="'.$i.$l.'" name="s[]" value="'.$i.'v'.$l.'" /><label for="'.$i.$l.'"><span>'.$l.'</span></label>';
                            }
                        }
                    print '</br>';
                  }

          ?>
    </div>

  </div>
  <div id="right_sala">
    <br><br><br><br>
    <label>Imie i nazwisko: </label><br> <input type="text" name="name" required placeholder="Jan Nowak" pattern="[A-ZĄĘŹŻŚÓĆŃŁ ]{1}[a-ząęźżśóćńł]* [A-ZĄĘŹŻŚÓĆŃŁ]{1}[a-ząęźżśóćńł]*"></br><br>
    <label>E-MAIL: </label><br> <input type="email" name="email" required placeholder="jnowak@wp.pl"/> <br><br>

  </div>
  <div id="footer_sala">
    <a href="index.php" class="button">POWRÓT</a>
    <input class="button" type="submit" value="REZERWUJ!"></form></div>
  </div>
<?php
}
else {
  print '<p class="error">Błąd, seans o podanym ID nie istnieje!</p>';
  print '<p class="info">Aby wrócić - <u><a href="index.php" title="kliknij, aby wrócić">kliknij tutaj...</a></u></p>';
}
?>