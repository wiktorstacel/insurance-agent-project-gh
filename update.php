<?php

require ('strona_kokpit_stage.inc');

class update extends kokpit_stage
{
   public function WyswietlPage()
    {

    echo '<div id="page_kokpit">
	<div id="content_kokpit">
		<div style="margin-bottom: 20px;">';

    $parametr = $_GET['id'];
		
    $title = $_POST['title'];

    $content = $_POST['freeRTE_content'];

    require 'config_db.php';
    $result1 = mysqli_query($conn, "UPDATE `articles` SET `title` = '$title' WHERE `article_id` = '$parametr' LIMIT 1")
    or die("Błąd w articles.title: " . mysqli_error($conn));
    $result2 = mysqli_query($conn, "UPDATE `articles` SET `content` = '$content' WHERE `article_id` = '$parametr' LIMIT 1")
    or die("Błąd w articles.content: " . mysqli_error($conn));

    print("Artykuł został zaktualizowany");




		
     echo'	</div>
		
     </div>
	<!-- end content -->';
	
    }
}


$pages_list = new update();

$pages_list -> title = 'Kokpit';

$pages_list -> keywords = 'kokpit';

$pages_list -> description = 'kokpit';

$pages_list -> Wyswietl();

?>
