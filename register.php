<?php

require ('strona_stage.inc');

class register extends Strona2
{
    
    public function WyswietlPage()
    {
        echo '
                <div id="rejestra_field">
                    <h1 class="title">Utwórz konto</h1>
                    <div id="rejestra_div">
                    <form id="rejestra_form" method="POST" action="register.php">
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
                            <br /><br />Płeć: 
                            <label id="rej_male" style="padding: 3px 4px 0 0;"><input id="rej_male_inp" type="radio" name="gender" value="male">M</label> 
                            <label id="rej_female" style="padding: 3px 4px 0 0;"><input id="rej_female_inp" type="radio" name="gender" value="female">K</label>
                            <br /><br /><br />
                            <label for="rej_haslo2">Znajomość języków obcych*: </label>
                            <br />
                            <label><input type="checkbox" name="language" id="language1" value="angielski" >angielski</label>
                            <label><input type="checkbox" name="language" id="language2" value="niemiecki" >niemiecki</label>
                            <label><input type="checkbox" name="language" id="language3" value="francuski" >francuski</label>
                            <label><input type="checkbox" name="language" id="language4" value="ukrainski" >ukraiński</label><br/>
                            <label><input type="checkbox" name="language" id="language5" value="hiszpanski" >hiszpański</label>
                            <label><input type="checkbox" name="language" id="language6" value="wloski">włoski</label>
                            <label><input type="checkbox" name="language" id="language7" value="rosyjski" >rosyjski</label>
                            <br /><br /><br />
                            <label><input id="rej_regulamin" type="checkbox" name="rej_regulamin" />Akceptuję </label>
                            <a href="regulamin.php">regulamin</a>
                            <br /><br />
                            <div style="width: 304px; margin: auto;" class="g-recaptcha" data-sitekey="6LfV2UUaAAAAAKkcskYoAimOqSAJMW0XLM78uu9d"></div> 
                            <br />
                            <input id="rejestra_submit" type="submit" value="Utwórz konto" />
                            <br />
                            <p id="rejestra_message"></p>
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

$register = new register($header_type, $show_content, $show_sidebar, $show_motto);

$register -> title = 'Rejestracja - utwórz konto';

$register -> keywords = 'ubezpieczenia, komunikacyjne, rzeszów, podkarpackie';

$register -> description = 'Rejestracja - utwórz konto';

$register -> Wyswietl();

?>
