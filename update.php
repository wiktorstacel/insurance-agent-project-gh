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
    $result1 = mysql_query("UPDATE `articles` SET `title` = '$title' WHERE `id` = '$parametr' LIMIT 1")
    or die("B��d w articles.title: " . mysql_error());
    $result2 = mysql_query("UPDATE `articles` SET `content` = '$content' WHERE `id` = '$parametr' LIMIT 1")
    or die("B��d w articles.content: " . mysql_error());

    print("Artyku� zosta� zaktualizowany");




		
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
