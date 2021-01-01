<?php

require ('strona_kokpit_stage.inc');

class page_newAdd extends kokpit_stage
{
   public function WyswietlPage()
    {

    echo '<div id="page_kokpit">
	<div id="content_kokpit">
		<div style="margin-bottom: 20px;">';
		
    $title = $_POST['title'];

    $content = $_POST['freeRTE_content'];

    require_once 'config_db.php';
    $zapytanie = "INSERT INTO `pages` ( `page_id` , `title` , `content`) VALUES (DEFAULT,'$title','$content')" ;
    $result = mysqli_query($conn, $zapytanie);
    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
    else
    {
        echo'Strona została dodana.';
    }



		
     echo'	</div>
		
     </div>
	<!-- end content -->';
	
    }
}


$page_newAdd = new page_newAdd();

$page_newAdd -> title = 'Kokpit';

$page_newAdd -> keywords = 'kokpit';

$page_newAdd -> description = 'kokpit';

$page_newAdd -> Wyswietl();

?>
