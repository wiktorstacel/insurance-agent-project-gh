<?php


require '../../strona_kokpit_stage.inc';     //strona_kokpit_stage.inc nie mo�e dziedziczy� do niczego innego, to nie zadzia�a

class edycja_pages extends kokpit_stage
{  	
   
    public function WyswietlStyle()
    {
      echo "<link rel=\"Stylesheet\" type=\"text/css\" href=\"../../css/css_agent.css\" />\n";
    }
    
   public function WyswietlSkrypty()
    {
        echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
        echo '<script language="JavaScript" type="text/javascript" src="../../js/js_agent.js"></script>';
        echo '<script language="JavaScript" type="text/javascript" src="../../js/jquery_agent.js"></script>';
    }

   public function WyswietlPage()
    {

    echo '<div id="page_edycja">
	<div id="content_edycja">
		<div style="margin-bottom: 20px;">';
	
        function freeRTE_Preload($content)
        {         //moze ta funkcaja jest do wyswietlania sformatowanego tekstu
            // Strip newline characters.                 //arkusz styli zapami�tuje formatowanie tekstu!!!
            $content = str_replace(chr(10), " ", $content);      //IntRTE przekszta�ca tekst html i css i wyswietla to co ma wyjsc
            $content = str_replace(chr(13), " ", $content);      //NIe css plik to tylko czcionka i jej rozmiar do inicjalizacji
            // Replace single quotes.
            $content = str_replace(chr(145), chr(39), $content);
            $content = str_replace(chr(146), chr(39), $content);
            // Return the result.
            return $content;
        }

      $parametr = $_GET['id'];

      if($parametr == "new")
      {

        echo '<center>';
        echo "Nowy strona ";
        echo '<br><br>';

        $content = "";

        $content = freeRTE_Preload($content);

        ?>
        <form enctype="multipart/form-data" name="new" method="post" action="../../page_newAdd.php">
        Tytuł: <input name="title" type="text" size="60" maxlength="200" style="text-align:left; color: black">
        <br /><br />
        <!-- Include the Free Rich Text Editor Runtime -->
        <script src="../js/richtext.js" type="text/javascript" language="javascript"></script>
        <!-- Include the Free Rich Text Editor Variables Page -->
        <script src="../js/config.js" type="text/javascript" language="javascript"></script>
        <!-- Initialise the editor -->
        <script>
        initRTE('<?= $content ?>', 'example.css');
        </script>
        <br />
        <input type="submit" value="Dodaj">
        </form>
        <?php

      }
      else
      {

        require '../../config_db.php';

        $result = mysqli_query($conn, "SELECT * FROM pages WHERE page_id LIKE \"$parametr\"");
        if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
        $row = mysqli_fetch_array($result, MYSQLI_NUM);

        echo '<center>';
        echo 'Edycja strony';
        echo '<br>';
        echo '<br><br>';

        $content = $row[2];

        $content = freeRTE_Preload($content);
        ?>
        <form enctype="multipart/form-data" name="new" method="post" action="../../page_update.php">
        <input id="page_id" type="hidden" name="page_id" value="<?php echo $parametr?>" />
        Tytuł: <input name="title" type="text" size="60" maxlength="200" value="<?php echo $row[1]?>" style="text-align:left; color: black">
        <br /><br />
        <!-- Include the Free Rich Text Editor Runtime -->
        <script src="../js/richtext.js" type="text/javascript" language="javascript"></script>
        <!-- Include the Free Rich Text Editor Variables Page -->
        <script src="../js/config.js" type="text/javascript" language="javascript"></script>
        <!-- Initialise the editor -->
        <script>
        initRTE('<?= $content ?>', 'example.css');
        </script>
        <br />
        <input type="submit" value="Zapisz">		
        </form>      
        <?php
       }
		
	echo'	</div>
		
	</div>
	<!-- end content -->';
	
    }
    public function WyswietlSidebar()
    {
      echo'<div style="clear: both;">&nbsp;</div>
     </div>';
    }
}


$edycja_pages = new edycja_pages();

$edycja_pages -> title = 'Kokpit';

$edycja_pages -> keywords = 'kokpit';

$edycja_pages -> description = 'kokpit';

$edycja_pages -> Wyswietl();

?>
