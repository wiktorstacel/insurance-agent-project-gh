<?php


require '../../strona_kokpit_stage.inc';

class edycja_articles extends kokpit_stage
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
    
        //echo '<div id="page_edycja">';
	echo '<div id="content_edycja">
		<main style="margin-bottom: 20px;">';
	echo '<center>';
        	
      $article_id = htmlentities($_GET['article_id'], ENT_QUOTES, "UTF-8");
      if(CheckUserOfArticle($article_id) == 0)
      {
          echo'<span>Błąd. Nie masz uprawnień do edytowania tego artykułu. Skontaktuj się z administratorem.</span>';
      }
      elseif(CheckUserOfArticle($article_id) == 1)
      {
      
            require'../../config_db.php';
            if($article_id == "new") //NOWY ARTYKUŁ
            {

                if(isset($_SESSION['mem_content']))//powrót z walidacji
                {
                    $category_id = $_SESSION['mem_category_id'];unset($_SESSION['mem_category_id']);
                    $title = $_SESSION['mem_title'];unset($_SESSION['mem_title']);
                    $content = $_SESSION['mem_content'];unset($_SESSION['mem_content']);
                }
                else //całkiem nowy
                {
                    $category_id = 0;
                    $title = NULL;
                    $content = NULL;
                }

                          
                echo "<h2>Nowy artykuł</h2>";
                echo '<br>';

              $content = freeRTE_Preload($content);

              ?>
              <form enctype="multipart/form-data" name="new" method="post" action="../../article_save.php">      
              Kategoria: <select name="category_id" id="category_id" class="">';
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
                if($category_id == 0)
                {
                    echo'<option value=0 selected="selected">-wybierz-</option>';
                }
                else
                {
                    echo'<option value=0 >-wybierz-</option>';
                }
              ?>
              </select>
              <?php
              if(isset($_SESSION['e_category']))
              {echo '<span class="form-error-little">'.$_SESSION['e_category'].'</span>'; unset($_SESSION['e_category']);}
              ?>
              <br /><br />
              Tytuł: <input name="title" type="text" size="50" maxlength="70" style="text-align:left; color: black" value="<?php echo $title?>">
              <?php
              if(isset($_SESSION['e_title']))
              {echo '<span class="form-error-little">'.$_SESSION['e_title'].'</span>'; unset($_SESSION['e_title']);}
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
              <a href="../../kokpit_articlesUser.php"><button style="margin-top: 6px;" type="" class="btn btn-secondary">Anuluj</button></a>
              <?php
            }
            else //EDYCJA ISTNIEJĄCEGO ARTYKUŁU
            {
                //powrót z walidacji, omijamy mysql
                if(isset($_SESSION['mem_content']))
                { 
                    $category_id = $_SESSION['mem_category_id']; unset($_SESSION['mem_category_id']);
                    $title = $_SESSION['mem_title']; unset($_SESSION['mem_title']);
                    $content = $_SESSION['mem_content']; unset($_SESSION['mem_content']);
                }
                else //zaciągnięcie z BD
                {
                    $result = mysqli_query($conn,
                          sprintf("SELECT * FROM articles WHERE article_id='%d'",
                          mysqli_real_escape_string($conn, $article_id)
                                      ));
                    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                    $row = mysqli_fetch_array($result, MYSQLI_NUM);
                    
                    $content = $row[2];
                    $category_id = $row[6];
                    $title = $row[1];
                }
                


              echo '<h2>Edycja artykułu</h2>';
              echo '<br>';

              $content = freeRTE_Preload($content);
              ?>
              <form enctype="multipart/form-data" name="new" method="post" action="../../article_save.php">
              <input id="article_id" type="hidden" name="article_id" value="<?php echo $article_id?>" />
              Kategoria: <select name="category_id" id="category_id" class="">';
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
                if($category_id == 0)
                {
                    echo'<option value=0 selected="selected">-wybierz-</option>';
                }
                else
                {
                    echo'<option value=0 >-wybierz-</option>';
                }
              ?>
              </select>
              <?php
              if(isset($_SESSION['e_category']))
              {echo '<span class="form-error-little">'.$_SESSION['e_category'].'</span>'; unset($_SESSION['e_category']);}
              ?>
              <br /><br />
              Tytuł: <input name="title" type="text" size="50" maxlength="200" value="<?php echo $title?>" style="text-align:left; color: black">
              <?php
              if(isset($_SESSION['e_title']))
              {echo '<span class="form-error-little">'.$_SESSION['e_title'].'</span>'; unset($_SESSION['e_title']);}
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
              <a href="../../kokpit_articlesUser.php"><button style="margin-top: 6px;" type="" class="btn btn-secondary">Anuluj</button></a>
              <?php       
             }//koniec seksji edycja istniejącego artykułu
      }	
	echo'	</main>
		
	</div>
	<!-- end content_edycja -->';
	
    }

}

$header_type = 3;
$show_content = true;
$show_sidebar = false; 

$edycja_articles = new edycja_articles($header_type, $show_content, $show_sidebar);

$edycja_articles -> title = 'Kokpit';

$edycja_articles -> keywords = 'kokpit';

$edycja_articles -> description = 'kokpit';

$edycja_articles -> Wyswietl();

?>
