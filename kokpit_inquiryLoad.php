<?php

require ('strona_kokpit_stage.inc');

class kokpit_userProfile extends kokpit_stage
{

    public function WyswietlPage()
    {

    echo '
	<div id="content_kokpit">
		<main style="margin-bottom: 20px;">';
                    
                    $inquiry_id = htmlentities($_GET['inquiry_id'], ENT_QUOTES, "UTF-8");
                    require_once 'config_db.php';
                    $result = mysqli_query($conn, 
                        sprintf("SELECT * FROM inquiries WHERE inquiry_id='%d' AND `user_id`='%d' ORDER BY date DESC",
                        mysqli_real_escape_string($conn, $inquiry_id),
                        mysqli_real_escape_string($conn, $_SESSION['user_id'])
                                ));
                    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                    $row = mysqli_fetch_assoc($result);
                    //change stan to 0 after load/read
                    if(mysqli_num_rows($result) < 1)
                    {
                        header('location: kokpit_inquiriesList.php'); //zalogowany próbuje czytać nie swoje wiadomości
                    }
                    else
                    {
                        $result = mysqli_query($conn, 
                        sprintf("UPDATE `inquiries` SET `stan`= 0 WHERE `inquiry_id`='%d' AND `user_id`='%d'",
                        mysqli_real_escape_string($conn, $inquiry_id),
                        mysqli_real_escape_string($conn, $_SESSION['user_id'])
                                ));                                        
                        if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}

                        echo'<div class="user_profile_left_title">Szczegóły</div>'
                          . '<div class="user_profile_right_title">zapytania</div>';
                        echo'<div style="clear:both"></div>';

                        echo'<div class="user_profile_left">Data nadania</div>'
                          . '<div class="user_profile_right">'.$row['date'].'</div>';
                        echo'<div style="clear:both"></div>';

                        echo'<div class="user_profile_left">Imię</div>'
                          . '<div class="user_profile_right">'.$row['name'].'</div>';
                        echo'<div style="clear:both"></div>';

                        echo'<div class="user_profile_left">Treść</div>'
                          . '<div class="user_profile_right">'.$row['inquiry'].'</div>';
                        echo'<div style="clear:both"></div>';

                        echo'<div class="user_profile_left">Adres e-mail</div>'
                          . '<div class="user_profile_right">'.$row['email'].'</div>';
                        echo'<div style="clear:both"></div>';

                        echo'<div class="user_profile_left">Numer telefonu</div>'
                          . '<div class="user_profile_right">'.$row['telefon'].'</div>';
                        echo'<div style="clear:both"></div>';

                        echo'<span><br><br>Do osoby tej zostało wysłane automatyczne potwierdzenie nadania wiadomości w momencie otrzymania jej przez serwis.</span>';
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

$kokpit_userProfile = new kokpit_userProfile($header_type, $show_content, $show_sidebar);

$kokpit_userProfile -> title = 'Kokpit';

$kokpit_userProfile -> keywords = 'kokpit';

$kokpit_userProfile -> description = 'kokpit';

$kokpit_userProfile -> Wyswietl();

?>
