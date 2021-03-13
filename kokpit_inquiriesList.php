<?php

require ('strona_kokpit_stage.inc');

class kokpit_inquiriesList extends kokpit_stage
{

    public function WyswietlPage()
    {

    echo '
	<div id="content_kokpit">
		<main style="margin-bottom: 20px;">';
    
                echo '<br>';
                echo '<table class="lista_art">';
                echo '<tr class="listwa">';
                echo '<td class="tytul">Treść zapytania</td>';
                echo '<td class="plus">Data nadania</td>';
                echo '<td>Wyświetl</td>';
                echo '<td>Usuń</td>';
                echo '</tr>';
                require_once 'config_db.php';
                $result = mysqli_query($conn, "SELECT * FROM inquiries WHERE user_id=".$_SESSION['user_id']." ORDER BY date DESC");
                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);} 
                while($row = mysqli_fetch_array($result, MYSQLI_NUM))
                {
                    if($row[6] == 1)      //sprawdzanie czy wpis ma być wyswietlany jako aktywny
                    {
                        echo'<tr class="linia">';
                    }
                    else
                    {
                        echo'<tr class="linia2">';
                    }
                    //$no_html = strip_tags($row[1]);
                    //$begin = substr($row[1], 0, 70);
                    echo'<td class="tytul">'.$row[1].'</td>';
                    echo'<td class="plus">'.$row[5].'</td>';
                    echo'<td class="plus"><a href="kokpit_inquiryLoad.php?inquiry_id='.$row[0].'">+</a></td>';
                    echo'<td class="plus"><a href="kokpit_inquiryDelConf.php?inquiry_id='.$row[0].'">+</a></td>';
                    echo '</tr>';
                }
                echo '</table>';
                echo '<br>';
    
                mysqli_close($conn);
		
	echo'	</main>
		
	</div>
	<!-- end content -->';
    }

}

$header_type = 2;
$show_content = true;
$show_sidebar = true; 

$kokpit_inquiriesList = new kokpit_inquiriesList($header_type, $show_content, $show_sidebar);

$kokpit_inquiriesList -> title = 'Kokpit';

$kokpit_inquiriesList -> keywords = 'kokpit';

$kokpit_inquiriesList -> description = 'kokpit';

$kokpit_inquiriesList -> Wyswietl();

?>
