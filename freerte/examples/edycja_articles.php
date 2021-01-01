<?php


require '../../strona_kokpit_stage.inc';

class edycja_articles extends kokpit_stage
{
  /* function freeRTE_Preload($content)
    {         //moze ta funkcaja jest do wyswietlania sformatowanego tekstu
        	// Strip newline characters.                 //arkusz styli zapamiętuje formatowanie tekstu!!!
        	$content = str_replace(chr(10), " ", $content);      //IntRTE przekształca tekst html i css i wyswietla to co ma wyjsc
        	$content = str_replace(chr(13), " ", $content);      //NIe css plik to tylko czcionka i jej rozmiar do inicjalizacji
        	// Replace single quotes.
        	$content = str_replace(chr(145), chr(39), $content);
        	$content = str_replace(chr(146), chr(39), $content);
        	// Return the result.
        	return $content;
     } */  	
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
		

      $parametr = $_GET['id'];
      
    function freeRTE_Preload($content)
    {         //moze ta funkcaja jest do wyswietlania sformatowanego tekstu
        // Strip newline characters.                 //arkusz styli zapamiętuje formatowanie tekstu!!!
        $content = str_replace(chr(10), " ", $content);      //IntRTE przekształca tekst html i css i wyswietla to co ma wyjsc
        $content = str_replace(chr(13), " ", $content);      //NIe css plik to tylko czcionka i jej rozmiar do inicjalizacji
        // Replace single quotes.
        $content = str_replace(chr(145), chr(39), $content);
        $content = str_replace(chr(146), chr(39), $content);
        // Return the result.
        return $content;
    }

      if($parametr == "new") //nowy artykuł
      {

        echo '<center>';
        echo "Nowy artykuł";
        echo '<br><br>';

        $content = "";

        $content = freeRTE_Preload($content);
        
        ?>
        <form enctype="multipart/form-data" name="new" method="post" action="../../article_newAdd.php">
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
      else //edycja istniejącego artykułu
      {

        require_once '../../config_db.php';

        $result = mysqli_query($conn, "SELECT * FROM articles WHERE article_id LIKE \"$parametr\"");
        if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
        $row = mysqli_fetch_array($result, MYSQLI_NUM);

        echo '<center>';
        echo 'Edycja artykułu';
        echo '<br>';
        echo '<br><br>';

        $content = $row[2];

        $content = freeRTE_Preload($content);
        ?>
        <form enctype="multipart/form-data" name="new" method="post" action="../../article_update.php">
        <input id="article_id" type="hidden" name="article_id" value="<?php echo $parametr?>" />
        Tytuł: <input name="title" type="text" size="60" maxlength="200" value="<?php echo $row[1]?>" style="text-align:left; color: black"><!--background-color: ; font-style: ; --!>
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


$edycja_articles = new edycja_articles();

$edycja_articles -> title = 'Kokpit';

$edycja_articles -> keywords = 'kokpit';

$edycja_articles -> description = 'kokpit';

$edycja_articles -> Wyswietl();

?>
