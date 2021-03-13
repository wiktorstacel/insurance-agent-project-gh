<?php

require ('strona_kokpit_stage.inc');

class kokpit_articlesUser extends kokpit_stage
{

    public function WyswietlPage()
    {

    echo '
	<div id="content_kokpit">
		<main style="margin-bottom: 20px;">';
    
                echo '<br>';
                echo '<table class="lista_art">';
                echo '<tr class="listwa">';
                echo '<td class="tytul">Tytuł artykułu</td>';
                echo '<td class="data">Data dodania</td>';
                echo '<td>W</td>';
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
                    if($row[4] == 1)      //sprawdzanie czy wpis ma być wyswietlany jako aktywny
                    {
                        echo'<tr class="linia">';
                    }
                    else
                    {
                        echo'<tr class="linia2">';
                    }
                    echo'<td class="tytul">'.$row[1].'</td>';
                    echo'<td class="data">'.$row[3].'</td>';
                    echo'<td class="plus">'.$row[7].'</td>';
                    echo'<td class="plus"><a href="article_preview.php?article_id='.$row[0].'">+</a></td>';
                    echo'<td class="plus"><a href="article_stanChange.php?article_id='.$row[0].'&from=2">+</a></td>';
                    echo'<td class="plus"><a href="freerte/examples/edycja_articles.php?article_id='.$row[0].'">+</a></td>';
                    echo'<td class="plus"><a href="article_deleteConfirm.php?article_id='.$row[0].'">+</a></td>';
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

$kokpit_articlesUser = new kokpit_articlesUser($header_type, $show_content, $show_sidebar);

$kokpit_articlesUser -> title = 'Kokpit';

$kokpit_articlesUser -> keywords = 'kokpit';

$kokpit_articlesUser -> description = 'kokpit';

$kokpit_articlesUser -> Wyswietl();

?>
