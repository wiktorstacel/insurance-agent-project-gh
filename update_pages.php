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
    $result1 = mysql_query("UPDATE `pages` SET `title` = '$title' WHERE `id_strona` = '$parametr' LIMIT 1")
    or die("B³¹d w articles.title: " . mysql_error());
    $result2 = mysql_query("UPDATE `pages` SET `content` = '$content' WHERE `id_strona` = '$parametr' LIMIT 1")
    or die("B³¹d w articles.content: " . mysql_error());

    print("Strona zosta³a zaktualizowana");




		
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
