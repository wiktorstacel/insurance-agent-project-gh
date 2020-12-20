<?php

require ('strona_stage.inc');

class rejestracja extends Strona2
{
    public function Wyswietl()
    {
      echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">';
      echo "<html>\n<head>\n";
      $this -> WyswietlTytul();
      $this -> WyswietlSlowaKluczowe();
      $this -> WyswietlOpis();
      $this -> WyswietlMeta();
      $this -> WyswietlStyle();
      $this -> WyswietlSkrypty();
      echo "</head>\n<body>\n";
      $this -> WyswietlHeader();
      $this -> WyswietlPage();
      $this -> WyswietlSidebar();
      $this -> WyswietlFooter();
//      $this -> WyswietlMenuPoziom($this->przyciski_poz);
//      $this -> WyswietlSearch();
//      $this -> WyswietlMenuPion($this->przyciski_pion);
//      $this -> WyswietlInformacje();
//            $this -> WyswietlTresc();
//      echo $this->tresc;
//     $this -> WyswietlStopke();
//      $this -> WyswietlZastopke();
      echo "</body>\n</html>\n";

    }
    
    public function WyswietlPage()
    {//
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
