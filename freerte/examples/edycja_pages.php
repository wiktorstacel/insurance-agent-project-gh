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
    
    public function WyswietlHeader()
    {
      echo '<div id="header_parent">';
      echo '<div id="header">
	<div id="logo">
		<h1><a href="#">Zarządzanie treścią witryny</a></h1>
	</div>
	<div id="menu">
		<ul>
			<li class="active"><a href="../../kokpit_pagesList.php">Powrót do kokpitu</a></li>
		</ul>
	</div>
     </div>';
     echo '</div>';
    }

    public function WyswietlPage()
    {
	
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
        
        function CheckUserPerm()
        {
            //sprawdzamy, czy zalogowany użytkownik chce edytować swój artykuł
            require '../../config_db.php';
            $result = mysqli_query($conn, 
                sprintf("SELECT * FROM `users` WHERE `perm`=1 AND `user_id`='%d'",
                mysqli_real_escape_string($conn, $_SESSION['user_id'])
                        ));
            if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
            $record_number = mysqli_num_rows($result);
            if($record_number > 0)
            {
                //użytkownik ma prawo tu być, można tu jeszcze sprawdzić inne warunki ew.
                //np isset($_POST['submit]) i zrobić walidację tutaj
                return 1; //pozwolenie na wyświetlenie formularza
            }
            else // użytkownik nie ma prawa tu być
            {
                return 0;
            }
        }
        
        
        echo '<div id="page_edycja">
	<div id="content_edycja">
		<div style="margin-bottom: 20px;">';
        echo '<center>';

      $page_id = htmlentities($_GET['page_id'], ENT_QUOTES, "UTF-8");
      if(CheckUserPerm() == 0)
      {
            echo'<span>Błąd. Nie masz uprawnień do edytowania zakładek strony głównej. Skontaktuj się z administratorem.</span>';
      }
      elseif(CheckUserPerm() == 1)
      {
        if($page_id == "new")
        {
            
          echo "<h2>Nowy strona</h2>";
          echo '<br>';

          $content = "";

          $content = freeRTE_Preload($content);

          ?>
          <form enctype="multipart/form-data" name="new" method="post" action="../../page_newAdd.php">
          Tytuł: <input name="title" type="text" size="13" maxlength="13" style="text-align:left; color: black"> Maks. długość: 13 znaków, bo jest to tytuł zakładki.
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
          echo'<a href="../../kokpit_pagesList.php"><button style="margin-top: 6px;" type="">Anuluj</button></a>';
        }
        else//edycja strony
        {

          require '../../config_db.php';

          $result = mysqli_query($conn, "SELECT * FROM pages WHERE page_id=$page_id");
          if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
          $row = mysqli_fetch_array($result, MYSQLI_NUM);

          echo '<h2>Edycja strony</h2>';
          echo '<br>';

          $content = $row[2];

          $content = freeRTE_Preload($content);
          ?>
          <form enctype="multipart/form-data" name="new" method="post" action="../../page_update.php">
          <input id="page_id" type="hidden" name="page_id" value="<?php echo $page_id?>" />
          Tytuł: <input name="title" type="text" size="13" maxlength="13" value="<?php echo $row[1]?>" style="text-align:left; color: black"> Maks. długość: 13 znaków, bo jest to tytuł zakładki.
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
          echo'<a href="../../kokpit_pagesList.php"><button style="margin-top: 6px;" type="">Anuluj</button></a>';
         }//koniec seksji edycji strony
      }//koniec if od sprawdzania usera
      
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
