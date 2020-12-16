<?php

require_once ('strona_kokpit_stage.inc');

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

    require_once 'config_db.php';
    $result1 = mysqli_query($conn, "UPDATE `pages` SET `title` = '$title' WHERE `page_id` = '$parametr' LIMIT 1")
    or die("Błąd w articles.title: " . mysqli_error($conn));
    $result2 = mysqli_query($conn, "UPDATE `pages` SET `content` = '$content' WHERE `page_id` = '$parametr' LIMIT 1")
    or die("Błąd w articles.content: " . mysqli_error($conn));

    print("Strona została zaktualizowana");




		
     echo'	</div>
		
     </div>
	<!-- end content -->';
	
    }
}


$stronaglowna = new update();

$stronaglowna -> title = 'Kokpit';

$stronaglowna -> keywords = 'kokpit';

$stronaglowna -> description = 'kokpit';

$stronaglowna -> Wyswietl();

?>
