<?php

require ('strona_kokpit_stage.inc');

class kokpit_userProfile extends kokpit_stage
{

    public function WyswietlPage()
    {

    echo '<div id="page_kokpit">
	<div id="content_kokpit">
		<div style="margin-bottom: 20px;">';
    
                echo '<br>';
                echo "<table class='lista_art'>";
                echo "<tr class='listwa'>";
                echo '<td class="tytul">Tytuł artykułu</td>';
                echo '<td class="data">Data dodania</td>';
                echo '<td>Podgląd</td>';
                echo '<td class="stan">Stan</td>';
                echo '<td>Edycja</td>';
                echo '<td>Usuń</td>';
                echo '</tr>';
                require_once 'config_db.php';
                $result = mysqli_query($conn, "SELECT * FROM articles WHERE user_id=".$_SESSION['user_id']." ORDER BY date DESC");
                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);} 
                while($row = mysqli_fetch_array($result, MYSQLI_NUM))
                {
                    if($row[4] == 1)      //sprawdzanie czy wpis ma by� wyswietlany jako aktywny
                    {
                        echo'<tr class="linia">';
                    }
                    else
                    {
                        echo'<tr class="linia2">';
                    }
                    echo'<td class="tytul">'.$row[1].'</td>';
                    echo'<td class="data">'.$row[3].'</td>';
                    echo'<td class="plus"><a href="article_preview.php?article_id='.$row[0].'">+</a></td>';
                    echo'<td class="plus"><a href="article_stanChange.php?article_id='.$row[0].'&from=2">+</a></td>';
                    echo'<td class="plus"><a href="freerte/examples/edycja_articles.php?id='.$row[0].'">+</a></td>';
                    echo'<td class="plus"><a href="del.php?id='.$row[0].'">+</a></td>';
                    echo '</tr>';
                }
                echo '</table>';
                echo '<br>';
    
                mysqli_close($conn);
		
	echo'	</div>
		
	</div>
	<!-- end content -->';
    }

}

$kokpit_userProfile = new kokpit_userProfile();

$kokpit_userProfile -> title = 'Kokpit';

$kokpit_userProfile -> keywords = 'kokpit';

$kokpit_userProfile -> description = 'kokpit';

$kokpit_userProfile -> Wyswietl();

?>
