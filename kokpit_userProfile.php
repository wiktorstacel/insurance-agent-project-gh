<?php

require ('strona_kokpit_stage.inc');

class pages_list extends kokpit_stage
{

 public function WyswietlPage()
    {

    echo '<div id="page_kokpit">
	<div id="content_kokpit">
		<div style="margin-bottom: 20px;">';
    
                    require_once 'config_db.php';
                    $result = mysqli_query($conn, "SELECT * FROM users WHERE user_id=".$_SESSION['user_id']."");
                    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                    $row = mysqli_fetch_assoc($result);
	
                    echo'<div class="user_profile_left_title">Profil</div>'
                      . '<div class="user_profile_right_title">Użytkownika</div>';
                    echo'<div style="clear:both"></div>';
    
                    echo'<div class="user_profile_left">Nazwa</div>'
                      . '<div class="user_profile_right">'.$row['login'].'</div>';
                    echo'<div style="clear:both"></div>';

                    echo'<div class="user_profile_left">Adres e-mail</div>'
                      . '<div class="user_profile_right">'.$row['email'].'</div>';
                    echo'<div style="clear:both"></div>';

                    echo'<div class="user_profile_left">Adres biura</div>'
                      . '<div class="user_profile_right">'.$row['gender'].'</div>';
                    echo'<div style="clear:both"></div>';
                    
                    echo'<div class="user_profile_left">Numer telefonu</div>'
                      . '<div class="user_profile_right">'.$row['gender'].'</div>';
                    echo'<div style="clear:both"></div>';

                    echo'<div class="user_profile_left">Płeć</div>'
                      . '<div class="user_profile_right">'.$row['gender'].'</div>';
                    echo'<div style="clear:both"></div>';
                    
                    echo'<div class="user_profile_left">Języki obce</div>'
                      . '<div class="user_profile_right">'.$row['languages'].'</div>';
                    echo'<div style="clear:both"></div>';
    
                    mysqli_close($conn);
		
	echo'	</div>
		
	</div>
	<!-- end content -->';
	}

}

$pages_list = new pages_list();

$pages_list -> title = 'Kokpit';

$pages_list -> keywords = 'kokpit';

$pages_list -> description = 'kokpit';

$pages_list -> Wyswietl();

?>
