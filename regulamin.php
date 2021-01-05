<?php

require ('strona_stage.inc');

class regulamin extends Strona2
{
    
    public function WyswietlPage()
    {
      echo '<div id="page">
        <div id="content" style="float:left;">
            <div style="margin-bottom: 20px;">';
            
             echo'<h1>Regulamin</h2><br>
             <div>
             1. Zarejstrowany użytkownik ma prawo dodać 1 artykuł dziennie.<br>
             2. Artykuły podlegają moderacji przez administratora.<br>
             3. Tylko użytkownik ze statusem administratora ma uprawnienia do edytowania treści podstron z menu głównego.<br>
             4. Zakaz używania przekleństw i publikowania obraźliwych treści.<br>
             5. Nakaz stosowania przepisów o ochronie danych osobowych RODO.<br>
             6. Za treści rasistowskie grozi odpowiedzialność karna.<br>
             7. Niniejsza strona internetowa/witryna ma charakter wyłącznie informacyjny. Odwiedzający ponosi odpowiedzlaność za wykorzystanie informacji tu zdobytych i to w jaki sposób 
             pokierował się tymi informacjami w podjętych przez siebie działaniach inwestycyjno-ubezpieczeniowych.<br>
             
             <br>* Pole nieobowiązkowe do zaznaczenia w rejestracji nowego konta lub wysyłania wiadomości.
             </div>';
        
            echo'</div>
        </div>';
    }
    
    /*public function WyswietlSidebar()
    {
	echo'<div id="sidebar" style="float:left;">';

//<!-- write sidebar content here -->

	echo'</div>
	<!-- end sidebar -->
	<div style="clear: both;">&nbsp;</div>
     </div><!-- end page -->';
    }*/

}

$regulamin = new regulamin();

$regulamin -> title = 'Regulamin';

$regulamin -> keywords = 'regulamin witryny';

$regulamin -> description = 'Treść regulaminu do zatwierdzenia';

$regulamin -> Wyswietl();

?>
