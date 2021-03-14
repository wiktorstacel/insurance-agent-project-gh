<?php

require ('strona_kokpit_stage.inc');

class article_deleteConfirm extends kokpit_stage
{
    
    public function WyswietlPage()
    {

    echo '
	<div id="content_kokpit">
		<main style="margin-bottom: 20px;">';
    
                echo '<br>';
                echo "<table class='lista_art'>";

                require_once 'config_db.php';
                if(isset($_GET['article_id']) && !isset($_GET['article_id_confirmation']))
                {
                    echo "<tr class='listwa'>";
                    echo '<td class="tytul">Tytuł artykułu</td>';
                    echo '<td class="data">Data dodania</td>';
                    echo '<td class="plus">Potwierdzenie</td>';
                    echo '</tr>';
                    $article_id = htmlentities($_GET['article_id'], ENT_QUOTES, "UTF-8");
                    $result = mysqli_query($conn, 
                        sprintf("SELECT * FROM articles WHERE article_id='%d' AND `user_id`='%d' ORDER BY date DESC",
                        mysqli_real_escape_string($conn, $article_id),
                        mysqli_real_escape_string($conn, $_SESSION['user_id'])
                                ));
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
                        echo'<td class="plus"><a href="article_deleteConfirm.php?article_id_confirmation='.$row[0].'"><button type="" class="btn btn-danger">Usuń</button></a>'
                        . '<a href="kokpit_articlesUser.php"><button style="margin-left: 6px;" type="" class="btn btn-secondary">Anuluj</button></a></td>';
                        echo '</tr>';
                    }

                }
                elseif(!isset($_GET['article_id']) && isset($_GET['article_id_confirmation']))
                {
                    //szukamy czy jest taki artykuł w bazie z id zalogowanego uzytkownika
                    $delete_id = htmlentities($_GET['article_id_confirmation'], ENT_QUOTES, "UTF-8");
                    $result = mysqli_query($conn, 
                        sprintf("SELECT * FROM `articles` WHERE `article_id`='%d' AND `user_id`='%d'",
                        mysqli_real_escape_string($conn, $delete_id),
                        mysqli_real_escape_string($conn, $_SESSION['user_id'])
                                ));
                    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                    $record_number = mysqli_num_rows($result);
                    if($record_number > 0)
                    {
                        $result = mysqli_query($conn, 
                        sprintf("DELETE FROM `articles` WHERE `article_id`='%d' AND `user_id`='%d'",
                        mysqli_real_escape_string($conn, $delete_id),
                        mysqli_real_escape_string($conn, $_SESSION['user_id'])
                                ));                                        
                        if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                        else
                        {
                            echo'<tr class="linia"><td>Artykuł został usunięty.</td></tr>';
                        }
                    }
                    else
                    {
                        echo '<tr class="linia"><td>Błąd. Artykuł nie został usunięty, '
                        . 'spróbuj ponownie lub skontaktuj się z administratorem.</td></tr>';
                    }                  
                }
                else //brak ustawionych zmiennych GET
                {
                    header('location: kokpit_articlesUser.php');
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

$article_deleteConfirm = new article_deleteConfirm($header_type, $show_content, $show_sidebar);

$article_deleteConfirm -> title = 'Kokpit';

$article_deleteConfirm -> keywords = 'kokpit';

$article_deleteConfirm -> description = 'kokpit';

$article_deleteConfirm -> Wyswietl();

?>
