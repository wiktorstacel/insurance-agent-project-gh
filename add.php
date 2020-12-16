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
    
    require_once 'config_db.php';
    $zapytanie = "INSERT INTO `articles` ( `article_id` , `title` , `content`,`date`, `stan`) VALUES (DEFAULT,'$title','$content','2010-01-09','1')" ;
    $result = mysql_query($conn, $zapytanie);
    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
    else
    {
    print("Artykuł został dodany");
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
