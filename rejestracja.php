<?php

require ('strona_stage.inc');

class rejestracja extends Strona2
{   
    public function WyswietlPage()
    {
        echo '<div id="page">
                <div id="rejestra_field">
                    <h1 class="title">Utwórz konto</h1>
                    <div id="rejestra_div">
                    <form id="rejestra_form" method="POST" action="rejestracja.php">
                            <fieldset>
                            <label for="rej_login">Login: </label>
                            <input id="rej_login" type="text" name="rej_login" value="" />
                            <br /><br />
                            <label for="rej_email">E-mail: </label>
                            <input id="rej_email" type="text" name="rej_email" value="" />
                            <br /><br />
                            <label for="rej_haslo">Twoje Hasło: </label>
                            <input id="rej_haslo" type="password" name="rej_haslo" value="" />
                            <br /><br />
                            <label for="rej_haslo2">Powtórz Hasło: </label>
                            <input id="rej_haslo2" type="password" name="rej_haslo2" value="" />
                            <br /><br />
                            <label>
                            <input id="rej_checkbox" type="checkbox" name="rej_checkbox" />Akceptuję regulamin
                            </label>
                            <br /><br />                        
                            <input id="rejestra_submit" type="submit" value="Utwórz konto" />
                            <br />
                            <p id="rejestra_message"></p>
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

$rejestracja = new rejestracja();

$rejestracja -> title = 'Rejestracja - utwórz konto';

$rejestracja -> keywords = 'ubezpieczenia, komunikacyjne, rzeszów, podkarpackie';

$rejestracja -> description = 'Rejestracja - utwórz konto';

$rejestracja -> Wyswietl();

?>