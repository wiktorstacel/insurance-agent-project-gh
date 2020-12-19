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

    require_once 'config_db.php';
    $zapytanie = "INSERT INTO `pages` ( `page_id` , `title` , `content`) VALUES (DEFAULT,'$title','$content')" ;
    $result = mysqli_query($conn, $zapytanie);
    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
    else
    {
    print("Strona została dodana");
    }



		
     echo'	</div>
		
     </div>
	<!-- end content -->';
	
    }
}


$pages_list = new add_pages();

$pages_list -> title = 'Kokpit';

$pages_list -> keywords = 'kokpit';

$pages_list -> description = 'kokpit';

$pages_list -> Wyswietl();

?>
