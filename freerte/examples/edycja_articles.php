<?php


require '../../strona_kokpit_stage.inc';

class edycja_articles extends kokpit_stage
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
			<li class="active"><a href="../../kokpit_articlesUser.php">Powrót do kokpitu</a></li>
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
        
        function CheckUserOfArticle($id)
        {
            //sprawdzamy, czy zalogowany użytkownik chce edytować swój artykuł
            require '../../config_db.php';
            $result = mysqli_query($conn, 
                sprintf("SELECT * FROM `articles` WHERE `article_id`='%d' AND `user_id`='%d'",
                mysqli_real_escape_string($conn, $id),
                mysqli_real_escape_string($conn, $_SESSION['user_id'])
                        ));
            if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
            $record_number = mysqli_num_rows($result);
            if($record_number > 0 || $id == "new")
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
        	
      $article_id = htmlentities($_GET['article_id'], ENT_QUOTES, "UTF-8");
      if(CheckUserOfArticle($article_id) == 0)
      {
          echo'<span>Błąd. Nie masz uprawnień do edytowania tego artykułu. Skontaktuj się z administratorem.</span>';
      }
      elseif(CheckUserOfArticle($article_id) == 1)
      {
      
            require'../../config_db.php';
            if($article_id == "new") //nowy artykuł
            {
          
              echo "<h2>Nowy artykuł</h2>";
              echo '<br>';

              $content = "";

              $content = freeRTE_Preload($content);

              ?>
              <form enctype="multipart/form-data" name="new" method="post" "action="../../article_newAdd.php>      
              Kategoria: <select name="category" id="category" class="">';
              <?php
              $result = mysqli_query($conn, "SELECT * FROM artcategories ORDER BY name ASC");
              if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
              while($row = mysqli_fetch_array($result, MYSQLI_NUM))
              { 
                  print("<option value=".$row[0].">".$row[1]."</option>");
              }
              ?>
              <option value=0 selected="selected">-wybierz-</option></select>
              <br /><br />
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
              <input type="submit" name="submit" value="Dodaj">
              </form>
              <?php
              echo'<a href="../../kokpit_articlesUser.php"><button style="margin-top: 6px;" type="">Anuluj</button></a>';

            }
            else //edycja istniejącego artykułu
            {
              $result = mysqli_query($conn,
                          sprintf("SELECT * FROM articles WHERE article_id='%d'",
                          mysqli_real_escape_string($conn, $article_id)
                                      ));
              if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
              $row = mysqli_fetch_array($result, MYSQLI_NUM);

              echo '<h2>Edycja artykułu</h2>';
              echo '<br>';

              $content = $row[2];
              $title = $row[1];
              $category_id = $row[6];

              $content = freeRTE_Preload($content);
              ?>
              <form enctype="multipart/form-data" name="new" method="post" action="../../article_update.php">
              <input id="article_id" type="hidden" name="article_id" value="<?php echo $article_id?>" />
              Kategoria: <select name="category" id="category" class="">';
              <?php
              $result = mysqli_query($conn, "SELECT * FROM artcategories ORDER BY name ASC");
              if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
              while($row = mysqli_fetch_array($result, MYSQLI_NUM))
              { 
                  if($category_id == $row[0])
                  {
                      print("<option selected=\"selected\" value=".$row[0].">".$row[1]."</option>");
                  }
                  else
                  {
                      print("<option value=".$row[0].">".$row[1]."</option>");
                  }
              }
              ?>
              <option value=0>-wybierz-</option></select>
              <br /><br />
              Tytuł: <input name="title" type="text" size="60" maxlength="200" value="<?php echo $title?>" style="text-align:left; color: black"><!--background-color: ; font-style: ; --!>
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
              <input type="submit" name="submit" value="Zapisz">
              </form>
              <?php
              echo'<a href="../../kokpit_articlesUser.php"><button style="margin-top: 6px;" type="">Anuluj</button></a>';
             }//koniec seksji edycja istniejącego artykułu
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
