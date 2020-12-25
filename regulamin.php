<?php

require ('strona_stage.inc');

class regulamin extends Strona2
{
    
    public function WyswietlPage()
    {
      echo '<div id="page">
        <div id="content" style="float:right;">
            <div style="margin-bottom: 20px;">';
            
             echo'<h1>Regulamin</h2><br>
             <div>
             1. Zakaz używania przekleństw i publikowania obraźliwych treści.<br>
             2. Nakaz stosowania przepisów o ochronie danych osobowych RODO.<br>
             3. Za treści rasistowskie grozi odpowiedzialność karna.<br>
             4. Niniejsza strona internetowa/witryna ma charakter wyłącznie informacyjny.<br>
             5. Odwiedzający ponosi odpowiedzlaność za wykorzystanie informacji tu zdobytych i to w jaki sposób 
             pokierował się tymi informacjami w podjętych przez siebie działaniach inwestycyjno-ubezpieczeniowych.<br>
             
             </div>';
        
            echo'</div>
        </div>';
    }
    
    public function WyswietlSidebar()
    {
	echo'<div id="sidebar" style="float:left;">';

//<!-- write sidebar content here -->

	echo'</div>
	<!-- end sidebar -->
	<div style="clear: both;">&nbsp;</div>
     </div><!-- end page -->';
    }

}

$regulamin = new regulamin();

$regulamin -> title = 'Regulamin';

$regulamin -> keywords = 'regulamin witryny';

$regulamin -> description = 'Treść regulaminu do zatwierdzenia';

$regulamin -> Wyswietl();

?>
