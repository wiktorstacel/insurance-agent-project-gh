<?php

require ('strona_kokpit_stage.inc');

class pages_list extends kokpit_stage
{

 public function WyswietlPage()
    {

    echo '<div id="page_kokpit">
	<div id="content_kokpit">
		<div style="margin-bottom: 20px;">';
		
        echo '<br>';
        echo "<table class='lista_art'>";
        echo "<tr class='listwa'>";
        print("<td class=\"id\">Id</td>");
        print("<td class=\"tytul\">Tytu³</td>");
        echo '<td>Podgl¹d</td>';
        echo '<td>Edycja</td>';
        echo '<td>Usuñ</td>';
        echo '</tr>';
        require 'config_db.php';
        $result = mysql_query("SELECT * FROM pages ORDER BY id_strona DESC");if($result != TRUE){echo 'B³ad zapytania MySQL, odpowiedŸ serwera: '.mysql_error();}
        while($row = mysql_fetch_array($result, MYSQL_NUM))
        {
                print("<tr class=\"linia\">");              //wpis ma byæ wyswietlany jako aktywny
                print("<td class=\"id\">$row[0]</td>");
                print("<td class=\"tytul\">$row[1]</td>");
                print("<td><a href=\"tekst.php?id=$row[0]\">+</a></td>");
                print("<td><a href=\"freerte/examples/edycja_pages.php?id=$row[0]\">+</a></td>");
                print("<td><a href=\"del.php?id=$row[0]\">+</a></td>");
                echo '</tr>';
        }
         echo '</table>';
         echo '<br>';




		
	echo'	</div>
		
	</div>
	<!-- end content -->';
	}

}

$stronaglowna = new pages_list();

$stronaglowna -> title = 'Kokpit';

$stronaglowna -> keywords = 'kokpit';

$stronaglowna -> description = 'kokpit';

$stronaglowna -> Wyswietl();

?>
