<?php

require ('strona_kokpit_stage.php');

class kokpit_userProfile extends kokpit_stage
{

    public function WyswietlPage()
    {

    echo '
	<div id="content_kokpit">
		<main style="margin-bottom: 20px;">';
    
                    require_once 'config_db.php';
                    $result = mysqli_query($conn, "SELECT * FROM users WHERE user_id=".$_SESSION['user_id']."");
                    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                    $row = mysqli_fetch_assoc($result);
	
                    echo'<div class="user_profile_left_title">Profil</div>'
                      . '<div class="user_profile_right_title">Użytkownika</div>';
                    echo'<div style="clear:both"></div>';
    
                    echo'<div class="user_profile_left">Login</div>'
                      . '<div class="user_profile_right">'.$row['login'].'</div>';
                    echo'<div style="clear:both"></div>';

                    echo'<div class="user_profile_left">Adres e-mail</div>'
                      . '<div class="user_profile_right">'.$row['email'].'</div>';
                    echo'<div style="clear:both"></div>';

                    echo'<div class="user_profile_left">Imię i Nazwisko</div>'
                      . '<div class="user_profile_right">'.$row['surname'].'</div>';
                    echo'<div style="clear:both"></div>';
                    
                    echo'<div class="user_profile_left">Adres biura</div>'
                      . '<div class="user_profile_right">'.$row['address'].'</div>';
                    echo'<div style="clear:both"></div>';
                    
                    echo'<div class="user_profile_left">Numer telefonu</div>'
                      . '<div class="user_profile_right">'.$row['tel_num'].'</div>';
                    echo'<div style="clear:both"></div>';

                    echo'<div class="user_profile_left">Obszar działalności</div>'
                      . '<div class="user_profile_right">'.$row['busi_area'].'</div>';
                    echo'<div style="clear:both"></div>';                    
                    
                    echo'<div class="user_profile_left">Płeć</div>'
                      . '<div class="user_profile_right">'.$row['gender'].'</div>';
                    echo'<div style="clear:both"></div>';
                    
                    echo'<div class="user_profile_left">Języki obce</div>'
                      . '<div class="user_profile_right">'.$row['languages'].'</div>';
                    echo'<div style="clear:both"></div>';
                    
                    echo'<span><br><br>Uzupełnij dane profilowe, będą one widoczne w zakładce "Kontakt" oraz pod Twoimi'
                    . ' artykułami jako reklama/kontakt do Ciebie.</span>';
    
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
