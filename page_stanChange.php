<?php

require ('strona_kokpit_stage.inc');

class page_stanChange extends kokpit_stage
{

    public function WyswietlPage()
    {

    echo '
	<div id="content_kokpit">
		<main style="margin-bottom: 20px;">';
    

                require_once 'config_db.php';
                $page_id = htmlentities($_GET['page_id'], ENT_QUOTES, "UTF-8");
                
                //sprawdzamy, czy zalogowany użytkownik ma uprawniania '1'
                $result = mysqli_query($conn, 
                    sprintf("SELECT * FROM `users` WHERE `perm`=1 AND `user_id`='%d'",
                    mysqli_real_escape_string($conn, $_SESSION['user_id'])
                            ));
                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                $record_number = mysqli_num_rows($result);
                if($record_number > 0)
                {
                    $result = mysqli_query($conn, 
                    sprintf("UPDATE `pages` SET `stan`= NOT stan, `update_date`=CURDATE(), `user_id`='%d' WHERE `page_id`='%d'",
                    mysqli_real_escape_string($conn, $_SESSION['user_id']),
                    mysqli_real_escape_string($conn, $page_id)
                            ));                                        
                    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                    else
                    {
                        header('location: kokpit_pagesList.php');
                    }
                }
                else
                {
                    echo 'Bład. Stan nie został zmieniony, spróbuj ponownie lub skontaktuj się z administratorem,'
                    . ' aby uzyskać odpowiednie uprawnienia do wykonania tej operacji.';
                }
                mysqli_close($conn);
		
	echo'	</main>
		
	</div>
	<!-- end content -->';
    }

}

$header_type = 2;
$show_content = true;
$show_sidebar = true; 

$page_stanChange = new page_stanChange($header_type, $show_content, $show_sidebar);

$page_stanChange -> title = 'Kokpit';

$page_stanChange -> keywords = 'kokpit';

$page_stanChange -> description = 'kokpit';

$page_stanChange -> Wyswietl();

?>
