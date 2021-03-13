<?php

require ('strona_stage.inc');

class reset_psw_rqst extends Strona2
{ 
    
    public function WyswietlPage()
    {
        echo '
                <div id="rejestra_field">
                    <h1 class="title">Odzyskiwanie hasła</h1>
                    <div id="res_psw_div">
                    <form id="res_psw_form" method="POST" action="reset_psw.php">
                            <fieldset>
                            <label for="res_psw_email">E-mail: </label>
                            <input id="res_psw_email" type="text" name="res_psw_email" value="" />
                            <br /><br />                        
                            <input id="res_psw_submit" type="submit" value="Wyślij" />
                            <br />
                            <p id="res_psw_message">Na podany adres zostanie wysłany link, który należy kliknąć, 
                            aby przejść do strony tworzenia nowego hasła.</p>
                            </fieldset>
                    </form>
                    </div>
                </div>
        ';
    }

}

$header_type = 2;
$show_content = true;
$show_sidebar = false; 
$show_motto = true;

$reset_psw_rqst = new reset_psw_rqst($header_type, $show_content, $show_sidebar, $show_motto);

$reset_psw_rqst -> title = 'Odzyskiwanie dostępu do konta';

$reset_psw_rqst -> keywords = 'ubezpieczenia';

$reset_psw_rqst -> description = 'Odzyskaj hasło';

$reset_psw_rqst -> Wyswietl();

?>
