<?php

require_once ('strona_kokpit_stage.inc');

class page_update extends kokpit_stage
{
   public function WyswietlPage()
    {

    echo '<div id="page_kokpit">
	<div id="content_kokpit">
		<div style="margin-bottom: 20px;">';

    $page_id = $_POST['page_id'];
		
    $title = $_POST['title'];

    $content = $_POST['freeRTE_content'];

    require_once 'config_db.php';
    $result1 = mysqli_query($conn, "UPDATE `pages` SET `title` = '$title' WHERE `page_id` = '$page_id' LIMIT 1")
    or die("Błąd w articles.title: " . mysqli_error($conn));
    $result2 = mysqli_query($conn, "UPDATE `pages` SET `content` = '$content' WHERE `page_id` = '$page_id' LIMIT 1")
    or die("Błąd w articles.content: " . mysqli_error($conn));

    echo 'Strona została zaktualizowana.';




		
     echo'	</div>
		
     </div>
	<!-- end content -->';
	
    }
}


$page_update = new page_update();

$page_update -> title = 'Kokpit';

$page_update -> keywords = 'kokpit';

$page_update -> description = 'kokpit';

$page_update -> Wyswietl();

?>
