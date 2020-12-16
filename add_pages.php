<?php

require ('strona_kokpit_stage.inc');

class add_pages extends kokpit_stage
{
   public function WyswietlPage()
    {

    echo '<div id="page_kokpit">
	<div id="content_kokpit">
		<div style="margin-bottom: 20px;">';
		
    $title = $_POST['title'];

    $content = $_POST['freeRTE_content'];

    require 'config_db.php';
    $zapytanie = "INSERT INTO `pages` ( `id_strona` , `title` , `content`) VALUES ( '','$title','$content')" ;
    $result = mysql_query($zapytanie);
    if($result != TRUE){echo 'B≥ad zapytania MySQL, odpowiedü serwera: '.mysql_error();}
    else
    {
    print("Strona zosta≥a dodana");
    }



		
     echo'	</div>
		
     </div>
	<!-- end content -->';
	
    }
}


$stronaglowna = new add_pages();

$stronaglowna -> title = 'Kokpit';

$stronaglowna -> keywords = 'kokpit';

$stronaglowna -> description = 'kokpit';

$stronaglowna -> Wyswietl();

?>
