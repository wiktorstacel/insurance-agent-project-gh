<?php

require ('strona_stage.inc');

class reset_psw extends Strona2
{   
    public function WyswietlPage()
    {
        echo '<div id="page">
                <div id="rejestra_field">
                    <h1 class="title">Odzyskiwanie hasła</h1>
                    <div id="res_psw_div">
                    <form id="res_psw_form" method="POST" action="reset_psw.php">
                            <fieldset>
                            <label for="res_email">E-mail: </label>
                            <input id="res_email" type="text" name="res_email" value="" />
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
    
    public function WyswietlSidebar()
    {
	echo'
            </div><!-- end page -->';
    }

}

$reset_psw = new reset_psw();

$reset_psw -> title = 'Odzyskiwanie dostępu do konta';

$reset_psw -> keywords = 'ubezpieczenia';

$reset_psw -> description = 'Odzyskaj hasło';

$reset_psw -> Wyswietl();

?>
