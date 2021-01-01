<?php

require ('strona_kokpit_stage.inc');

class article_update extends kokpit_stage
{
   public function WyswietlPage()
    {

    echo '<div id="page_kokpit">
	<div id="content_kokpit">
		<div style="margin-bottom: 20px;">';

    $article_id = $_POST['article_id'];
		
    $title = $_POST['title'];

    $content = $_POST['freeRTE_content'];

    require 'config_db.php';
    $result1 = mysqli_query($conn, "UPDATE `articles` SET `title` = '$title' WHERE `article_id` = '$article_id' LIMIT 1")
    or die("Błąd w articles.title: " . mysqli_error($conn));
    $result2 = mysqli_query($conn, "UPDATE `articles` SET `content` = '$content' WHERE `article_id` = '$article_id' LIMIT 1")
    or die("Błąd w articles.content: " . mysqli_error($conn));

    echo'Artykuł został zaktualizowany.';




		
     echo'	</div>
		
     </div>
	<!-- end content -->';
	
    }
}


$article_update = new article_update();

$article_update -> title = 'Kokpit';

$article_update -> keywords = 'kokpit';

$article_update -> description = 'kokpit';

$article_update -> Wyswietl();

?>
