<div id="movie">

  <div id="header_movie">
    <div id="title_movie">TYTUŁ FILMU</div>
    <?php
      $day_array = array(1=>'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela');
      foreach ($day_array as $day_value => $day_string) {
        print '<div class="day">'.$day_string.'</div>';
      }
     ?>
  </div>

  <?php
    $movie_query = ($db->query("select * from SEANSE group by TITLE")); //zapytanie o wszystkie filmy, zgrupowane po tytule
    while ($r = $movie_query->fetch()){
      print '<div id="header_movie">';
      print '<div id="title_movie">'.$r['title'].'</div>';

        foreach ($day_array as $day_value => $day_string) {
          print '<div class="day">';
          $day = $day_value;
          $title = $r['title'];
          $day_query = ($db->query("select id_seans,time from SEANSE where day = '$day' and title like '$title'"));
            print "&nbsp";
            while ($time = $day_query->fetch()){
              print '<a href="index.php?id_seans='.$time['id_seans'].'" title="kliknij, aby przejść do rezerwacji">'.$time['time'].'</a>';
              print '<br>';
            }
            print '</div>';
        }

      print '</div>';
    }

  ?>
</div>
