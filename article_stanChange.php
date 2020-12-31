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
                $from = htmlentities($_GET['from'], ENT_QUOTES, "UTF-8");
                $result = mysqli_query($conn, "UPDATE `articles` SET `stan`= NOT stan WHERE `article_id`=$article_id");
                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                else
                {
                    if($from == 1) header('location: kokpit_articlesList.php');
                    elseif($from == 2) header('location: kokpit_articlesUser.php');
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
