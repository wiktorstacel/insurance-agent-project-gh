<?php

require ('strona_kokpit_stage.inc');

class pages_list extends kokpit_stage
{

 public function WyswietlPage()
    {

    echo '<div id="page_kokpit">
	<div id="content_kokpit">
		<div style="margin-bottom: 20px;">';
		
        echo '<br>';
        echo '<table class="lista_art">';
        echo '<tr class="listwa">';
        echo '<td class="id">Id</td>';
        echo '<td class="tytul">Tytuł - nazwa przycisku w menu głównym</td>';
        echo '<td class="data">Aktualizacja</td>';
        echo '<td>Podgląd</td>';
        echo '<td>Edycja</td>';
        echo '<td>Stan</td>';
        echo '</tr>';
        require_once 'config_db.php';
        $result = mysqli_query($conn, "SELECT * FROM pages ORDER BY page_id ASC");
        if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
        while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        {
            if($row[5] == 1)      //sprawdzanie czy wpis ma być wyswietlany jako aktywny
            {
                echo'<tr class="linia">';
            }
            else
            {
                echo'<tr class="linia2">';
            }
            echo'<td class="plus">'.$row[0].'</td>';
            echo'<td class="tytul">'.$row[1].'</td>';
            echo'<td class="data">'.$row[3].'</td>';
            echo'<td class="plus"><a href="page_preview.php?page_id='.$row[0].'">+</a></td>';
            echo'<td class="plus"><a href="freerte/examples/edycja_pages.php?id='.$row[0].'">+</a></td>';
            echo'<td class="plus"><a href="del.php?id='.$row[0].'">+</a></td>';
            echo '</tr>';
        }
         echo '</table>';
         echo '<br>';




		
	echo'	</div>
		
	</div>
	<!-- end content -->';
	}

}

$pages_list = new pages_list();

$pages_list -> title = 'Kokpit';

$pages_list -> keywords = 'kokpit';

$pages_list -> description = 'kokpit';

$pages_list -> Wyswietl();

?>
