<?php

require ('strona_stage.inc');

class reset_psw_new extends Strona2
{ 
    
    public function OdzyskajKonto()
    {
        //logika
        if(!isset($_GET['selector']) || !isset($_GET['validator']))
        {
            header('location: login.php');
            exit();
        }
        else
        {
            $selector = $_GET['selector'];
            $validator = $_GET['validator'];
            if(empty($selector) || empty($validator))
            {
                echo 'Brak potrzebnych danych.</span>';
                exit();
            }
            else
            {
                //funkcja sprawdza czy w zmiennej są tylko znaki HEX
                if(ctype_xdigit($selector) !== false || ctype_xdigit($validator) !== false)
                {
                    echo '<input id="new_psw_selector" type="hidden" name="selector" value="'.$selector.'" />';
                    echo '<input id="new_psw_validator" type="hidden" name="selector" value="'.$validator.'" />';                    
                }
                else
                {
                    echo 'Nieprawidłowe dane.</span>';
                    exit();
                }
            }
        }
    }
    
    public function WyswietlPage()
    {
        echo '
                <div id="rejestra_field">
                    <h1 class="title">Resetowanie hasła</h1>
                    <div id="res_psw_div">
                    <form id="new_psw_form" method="POST" action="reset_psw_new.php">
                            <fieldset>';
                            $this->OdzyskajKonto();
                            echo'<label for="new_psw_haslo">Nowe Hasło: </label>
                            <input id="new_psw_haslo" type="password" name="new_psw_haslo" value="" />
                            <br /><br />
                            <label for="new_psw_haslo2">Powtórz Hasło: </label>
                            <input id="new_psw_haslo2" type="password" name="new_psw_haslo2" value="" />
                             <br /><br />
                            <input id="new_psw_submit" type="submit" value="Zatwierdź" />
                            <br /><br />
                            <p id="new_psw_message">Wprowadź nowe hasło.</p>
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

$reset_psw_new = new reset_psw_new($header_type, $show_content, $show_sidebar, $show_motto);

$reset_psw_new -> title = 'Odzyskiwanie dostępu do konta';

$reset_psw_new -> keywords = 'ubezpieczenia';

$reset_psw_new -> description = 'Odzyskaj hasło';

$reset_psw_new -> Wyswietl();

?>
