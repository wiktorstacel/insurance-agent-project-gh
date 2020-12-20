<?php

require ('strona_kokpit_stage.inc');

class add_article extends kokpit_stage
{
   public function WyswietlPage()
    {

    echo '<div id="page_kokpit">
	<div id="content_kokpit">
		<div style="margin-bottom: 20px;">';
		
    $title = $_POST['title'];

    $content = $_POST['freeRTE_content'];
    
    require_once 'config_db.php';
    $zapytanie = "INSERT INTO `articles` ( `article_id` , `title` , `content`,`date`, `stan`) VALUES (DEFAULT,'$title','$content',CURDATE(),'1')" ;
    $result = mysqli_query($conn, $zapytanie);
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


$add_article = new add_article();

$add_article -> title = 'Kokpit';

$add_article -> keywords = 'kokpit';

$add_article -> description = 'kokpit';

$add_article -> Wyswietl();

?>
