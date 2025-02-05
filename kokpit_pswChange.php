<?php

require ('strona_kokpit_stage.php');

class kokpit_pswChange extends kokpit_stage
{

    public function WyswietlPage()
    {

    echo '
	<div id="content_kokpit">
		<div style="margin-bottom: 20px;">';
    
                    require_once 'config_db.php';
                    $result = mysqli_query($conn, "SELECT * FROM users WHERE user_id=".$_SESSION['user_id']."");
                    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                    $row = mysqli_fetch_assoc($result);
                    
                    echo'<div class="user_profile_left_title">Zmiana hasła</div>'
                      . '<div class="user_profile_right_title">Zachowaj bezpieczeństwo</div>';
                    echo'<div style="clear:both"></div>';
	
            echo'<div id="rejestra_field">
                    <div id="res_psw_div">
                    <form id="cha_psw_form" method="POST" action="kokpit_pswChangeAction.php">
                            <fieldset>';
                            echo '<input id="cha_psw_login" type="hidden" name="cha_psw_login" value="'.$row['login'].'" />';
                            echo'<label for="cha_psw_haslo0">Stare Hasło: </label>
                            <input id="cha_psw_haslo0" type="password" name="new_psw_haslo0" value="" />
                            <br /><br />
                            <label for="cha_psw_haslo">Nowe Hasło: </label>
                            <input id="cha_psw_haslo" type="password" name="cha_psw_haslo" value="" />
                            <br /><br />
                            <label for="cha_psw_haslo2">Powtórz Hasło: </label>
                            <input id="cha_psw_haslo2" type="password" name="cha_psw_haslo2" value="" />
                             <br /><br />
                            <input id="cha_psw_submit" type="submit" value="Zatwierdź" class="btn btn-primary" />
                            <br /><br />
                            <p id="cha_psw_message">Zmień hasło na nowe.</p>
                            </fieldset>
                    </form>
                    </div>
                </div>';
    
                    mysqli_close($conn);
		
	echo'	</div>
		
	</div>
	<!-- end content -->';
    }

}

$header_type = 2;
$show_content = true;
$show_sidebar = true; 

$kokpit_pswChange = new kokpit_pswChange($header_type, $show_content, $show_sidebar);

$kokpit_pswChange -> title = 'Kokpit';

$kokpit_pswChange -> keywords = 'kokpit';

$kokpit_pswChange -> description = 'kokpit';

$kokpit_pswChange -> Wyswietl();

?>
