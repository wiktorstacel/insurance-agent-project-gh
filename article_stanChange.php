<?php

require ('strona_kokpit_stage.inc');

class article_stanChange extends kokpit_stage
{

    public function WyswietlPage()
    {

    echo '<div id="page_kokpit">
	<div id="content_kokpit">
		<div style="margin-bottom: 20px;">';
    

                require_once 'config_db.php';
                $article_id = htmlentities($_GET['article_id'], ENT_QUOTES, "UTF-8");
                $from = $_GET['from'];
                
                //szukamy czy jest taki artykuł w bazie z id zalogowanego uzytkownika
                $result = mysqli_query($conn, 
                    sprintf("SELECT * FROM `articles` WHERE `article_id`='%d' AND `user_id`='%d'",
                    mysqli_real_escape_string($conn, $article_id),
                    mysqli_real_escape_string($conn, $_SESSION['user_id'])
                            ));
                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                $record_number = mysqli_num_rows($result);
                if($record_number > 0)
                {
                    $result = mysqli_query($conn, 
                    sprintf("UPDATE `articles` SET `stan`= NOT stan WHERE `article_id`='%d' AND `user_id`='%d'",
                    mysqli_real_escape_string($conn, $article_id),
                    mysqli_real_escape_string($conn, $_SESSION['user_id'])
                            ));                                        
                    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                    else
                    {
                        if($from == 1) header('location: kokpit_articlesList.php');
                        elseif($from == 2) header('location: kokpit_articlesUser.php');
                    }
                }
                else
                {
                    echo 'Bład. Stan nie został zmieniony, spróbuj ponownie lub skontaktuj się z administratorem.';
                }
                mysqli_close($conn);
		
	echo'	</div>
		
	</div>
	<!-- end content -->';
    }

}

$article_stanChange = new article_stanChange();

$article_stanChange -> title = 'Kokpit';

$article_stanChange -> keywords = 'kokpit';

$article_stanChange -> description = 'kokpit';

$article_stanChange -> Wyswietl();

?>
