<?php


require '../../strona_kokpit_stage.php';     //strona_kokpit_stage.php nie mo�e dziedziczy� do niczego innego, to nie zadzia�a

class edycja_pages extends kokpit_stage
{  	
   
    public function WyswietlStyle()
    {
      echo "<link rel=\"Stylesheet\" type=\"text/css\" href=\"../../css/css_agent.css\" />\n";
      echo '<link rel="icon" type="image/png" sizes="16x16" href="../../css/images/favicon.png">';
      echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">';
    }
    
    public function WyswietlSkrypty()
    {
        echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>';
        echo '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>';
        echo '<script language="JavaScript" type="text/javascript" src="../../js/js_agent.js"></script>';
        echo '<script language="JavaScript" type="text/javascript" src="../../js/jquery_agent.js"></script>';
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
        
        
        //echo '<div id="page_edycja">';
	echo '<div id="content_edycja">
		<main style="margin-bottom: 20px;">';
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

            if(isset($_SESSION['mem_content']))//powrót z walidacji
            {
                $title = $_SESSION['mem_title'];unset($_SESSION['mem_title']);
                $content = $_SESSION['mem_content'];unset($_SESSION['mem_content']);
            }
            else //całkiem nowy
            {
                $title = NULL;
                $content = NULL;
            }

          $content = freeRTE_Preload($content);

          ?>
          <form enctype="multipart/form-data" name="new" method="post" action="../../page_save.php">
          Tytuł: <input name="title" type="text" size="13" maxlength="13" value="<?php echo $title?>" style="text-align:left; color: black"> 
          <?php
          if(isset($_SESSION['e_title']))
          {echo '<span class="form-error-little">'.$_SESSION['e_title'].'</span>'; unset($_SESSION['e_title']);}
          else {echo'Maks. długość: 13 znaków, bo jest to tytuł zakładki.';}
          ?>         
          <br /><br />
          <!-- Include the Free Rich Text Editor Runtime -->
          <script src="../js/richtext.js" type="text/javascript" language="javascript"></script>
          <!-- Include the Free Rich Text Editor Variables Page -->
          <script src="../js/config.js" type="text/javascript" language="javascript"></script>
          <!-- Initialise the editor -->
          <script>
          initRTE('<?= $content ?>', 'example.css');
          </script>
          <?php
          if(isset($_SESSION['e_content']))
          {echo '<span class="form-error-little">'.$_SESSION['e_content'].'</span><br>'; unset($_SESSION['e_content']);}
          ?>
          <br />
          <input type="submit" name="submit" value="Dodaj" class="btn btn-primary">
          </form>
          <a href="../../kokpit_pagesList.php"><button style="margin-top: 6px;" type="" class="btn btn-secondary">Anuluj</button></a>
        <?php
        }
        else//EDYCJA STRONY
        {
            //powrót z walidacji, omijamy mysql
            if(isset($_SESSION['mem_content']))
            {
                $title = $_SESSION['mem_title']; unset($_SESSION['mem_title']);
                $content = $_SESSION['mem_content']; unset($_SESSION['mem_content']);
            }
            else //zaciągnięcie z BD
            {
                require '../../config_db.php';
                $result = mysqli_query($conn, "SELECT * FROM pages WHERE page_id=$page_id");
                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                $row = mysqli_fetch_array($result, MYSQLI_NUM);

                $title = $row[1];
                $content = $row[2];
            }
            
          echo '<h2>Edycja strony</h2>';
          echo '<br>';

          $content = freeRTE_Preload($content);
          ?>
          <form enctype="multipart/form-data" name="new" method="post" action="../../page_save.php">
          <input id="page_id" type="hidden" name="page_id" value="<?php echo $page_id?>" />
          Tytuł: <input name="title" type="text" size="13" maxlength="13" value="<?php echo $title?>" style="text-align:left; color: black">
          <?php
          if(isset($_SESSION['e_title']))
          {echo '<span class="form-error-little">'.$_SESSION['e_title'].'</span>'; unset($_SESSION['e_title']);}
          else {echo'Maks. długość: 13 znaków, bo jest to tytuł zakładki.';}
          ?>
          <br /><br />
          <!-- Include the Free Rich Text Editor Runtime -->
          <script src="../js/richtext.js" type="text/javascript" language="javascript"></script>
          <!-- Include the Free Rich Text Editor Variables Page -->
          <script src="../js/config.js" type="text/javascript" language="javascript"></script>
          <!-- Initialise the editor -->
          <script>
          initRTE('<?= $content ?>', 'example.css');
          </script>
          <?php
          if(isset($_SESSION['e_content']))
          {echo '<span class="form-error-little">'.$_SESSION['e_content'].'</span><br>'; unset($_SESSION['e_content']);}
          ?>
          <br />
          <input type="submit" name="submit" value="Zapisz" class="btn btn-primary">		
          </form>      
          <a href="../../kokpit_pagesList.php"><button style="margin-top: 6px;" type="" class="btn btn-secondary">Anuluj</button></a>
          <?php          
         }//koniec seksji edycji strony
      }//koniec if od sprawdzania usera
      
	echo'	</main>
		
	</div>
	<!-- end content -->';
	
    }

}

$header_type = 3;
$show_content = true;
$show_sidebar = false;

$edycja_pages = new edycja_pages($header_type, $show_content, $show_sidebar);

$edycja_pages -> title = 'Kokpit';

$edycja_pages -> keywords = 'kokpit';

$edycja_pages -> description = 'kokpit';

$edycja_pages -> Wyswietl();

?>
