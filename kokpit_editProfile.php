<?php

require ('strona_kokpit_stage.inc');

class kokpit_editProfile extends kokpit_stage
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
    
                    echo'<div class="user_profile_left">Nazwa użytkownika - login</div>'
                      . '<div class="user_profile_right"><input id="edit_login" type="text" name="edit_login" disabled value="'.$row['login'].'" /></div>';
                    echo'<div style="clear:both"></div>';

                    echo'<div class="user_profile_left">Adres e-mail</div>'
                      . '<div class="user_profile_right"><input id="edit_email" type="text" name="edit_email" value="'.$row['email'].'" /></div>';
                    echo'<div style="clear:both"></div>';

                    echo'<div class="user_profile_left">Imię i Nazwisko</div>'
                      . '<div class="user_profile_right"><input id="edit_surname" type="text" name="edit_surname" value="'.$row['surname'].'" /></div>';
                    echo'<div style="clear:both"></div>';
                    
                    echo'<div class="user_profile_left">Adres biura</div>'
                      . '<div class="user_profile_right"><textarea name="edit_address" cols="52" rows="2" type="text" value="" id="edit_address" class="">'.$row['address'].'</textarea></div>';
                    echo'<div style="clear:both"></div>';
                    
                    echo'<div class="user_profile_left">Numer telefonu</div>'
                      . '<div class="user_profile_right"><input id="edit_tel_num" type="text" name="edit_tel_num" value="'.$row['tel_num'].'" /></div>';
                    echo'<div style="clear:both"></div>';

                    echo'<div class="user_profile_left">Obszar działalności</div>'
                      . '<div class="user_profile_right"><textarea name="edit_busi_area" cols="52" rows="3" type="text" value="" id="edit_busi_area" class="">'.$row['busi_area'].'</textarea></div>';
                    echo'<div style="clear:both"></div>';                    
                    
                    echo'<div class="user_profile_left">Płeć</div>'
                      . '<div class="user_profile_right">';                    
                            echo'<select id="edit_gender" class="" name="edit_gender">';
                            if($row['gender'] == "male")
                            {             
                                echo'<option selected="selected" value="male">Mężczyzna</option>';
                                echo'<option value="female">Kobieta</option>';
                            }
                            else
                            {
                                echo'<option selected="selected" value="female">Kobieta</option>';
                                echo'<option value="male">Mężczyzna</option>';            
                            }
                            echo'</select>';                       
                    echo'</div>';//end of user_profile_right
                    echo'<div style="clear:both"></div>';
                    
                    echo'<div class="user_profile_left">Języki obce</div>'
                      . '<div class="user_profile_right">'
                        . '<input class="long_input" id="edit_languages" type="text" name="edit_languages" value="'.$row['languages'].'" /></div>';
                    echo'<div style="clear:both"></div>';
                    
                    echo'<div class="user_profile_left">Zatwierdź zmianę danych</div>'
                      . '<div class="user_profile_right"><button id="edit_submit" type="">Zapisz</button>&nbsp;<span id="edit_message"></span></div>';
                    echo'<div style="clear:both"></div>';
    
                    mysqli_close($conn);
		
	echo'	</div>
		
	</div>
	<!-- end content -->';
    }

}

$kokpit_editProfile = new kokpit_editProfile();

$kokpit_editProfile -> title = 'Kokpit';

$kokpit_editProfile -> keywords = 'kokpit';

$kokpit_editProfile -> description = 'kokpit';

$kokpit_editProfile -> Wyswietl();

?>
