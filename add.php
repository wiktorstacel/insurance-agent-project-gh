<?php

require ('strona_kokpit_stage.inc');

class add extends kokpit_stage
{
   public function WyswietlPage()
    {

    echo '<div id="page_kokpit">
	<div id="content_kokpit">
		<div style="margin-bottom: 20px;">';
		
    $title = $_POST['title'];

    $content = $_POST['freeRTE_content'];
    
    require 'config_db.php';
    $zapytanie = "INSERT INTO `articles` ( `id` , `title` , `content`,`date`, `stan`) VALUES ( '','$title','$content','2010-01-09','1')" ;
    $result = mysql_query($zapytanie);
    if($result != TRUE){echo 'B≥ad zapytania MySQL, odpowiedü serwera: '.mysql_error();}
    else
    {
    print("Artyku≥ zosta≥ dodany");
    }



		
     echo'	</div>
		
     </div>
	<!-- end content -->';
	
    }
}


$stronaglowna = new add();

$stronaglowna -> title = 'Kokpit';

$stronaglowna -> keywords = 'kokpit';

$stronaglowna -> description = 'kokpit';

$stronaglowna -> Wyswietl();

?>
