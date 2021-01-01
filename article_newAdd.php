<?php

require ('strona_kokpit_stage.inc');

class article_newAdd extends kokpit_stage
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
        echo'Artykuł został dodany.';
    }



		
     echo'	</div>
		
     </div>
	<!-- end content -->';
	
    }
}


$article_newAdd = new article_newAdd();

$article_newAdd -> title = 'Kokpit';

$article_newAdd -> keywords = 'kokpit';

$article_newAdd -> description = 'kokpit';

$article_newAdd -> Wyswietl();

?>
