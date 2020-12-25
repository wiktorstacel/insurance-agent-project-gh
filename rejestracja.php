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
                            <br /><br />Płeć*: 
                            <label><input type="radio" name="gender" value="male">M</label> 
                            <label><input type="radio" name="gender" value="female">K</label>
                            <br /><br />
                            <label for="rej_haslo2">Znajomość języków obcych*: </label>
                            <br />
                            <label><input type="checkbox" name="language" id="language1" value="angielski" >angielski</label>
                            <label><input type="checkbox" name="language" id="language2" value="niemiecki" >niemiecki</label>
                            <label><input type="checkbox" name="language" id="language3" value="francuski" >francuski</label>
                            <label><input type="checkbox" name="language" id="language4" value="ukrainski" >ukraiński</label><br/>
                            <label>
                            <br /><br /> 
                            <input id="rej_regulamin" type="checkbox" name="rej_regulamin" />Akceptuję regulamin
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
