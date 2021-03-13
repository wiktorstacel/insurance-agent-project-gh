<?php

require ('strona_kokpit_stage.inc');

class article_save extends kokpit_stage
{
    public function WyswietlPage()
    {
        echo '
            <div id="content_kokpit">
                    <main style="margin-bottom: 20px;">';
       
        $category_id = htmlentities($_POST['category_id'], ENT_QUOTES, "UTF-8");
        $title = htmlentities($_POST['title'], ENT_QUOTES, "UTF-8"); 
        $content = $_POST['freeRTE_content'];
        
        //Walidacja
        if(isset($_POST['submit']))
        {
            $validation_OK = true;
            
            if($category_id == 0)
            {
                $validation_OK = false;
                $_SESSION['e_category'] = "Przypisz artykuł do kategorii!";
            }
            
            if(strlen($title) < 15 || strlen($title) > 128)
            {
                $validation_OK = false;
                $_SESSION['e_title'] = "Tytuł musi mieć długość od 15 do 128 znaków!";
            }           
            elseif(!preg_match("/^(ą|ę| |\,|\.|\-|\?|\!|\%|ź|ć|ń|ó|&oacute;|ś|ż|ł|Ą|Ę|Ź|Ć|Ń|Ó|Ś|Ż|[0-9]|[a-z]|[A-Z]){15,64}$/", $title))
            {
                $validation_OK = false;
                $_SESSION['e_title'] = "Dozwolone litery, cyfry, spacja oraz !?,.-!";
            }
            
            if(strlen($content) < 100 || strlen($content) >100000)
            {
                $validation_OK = false;
                $_SESSION['e_content'] = "Artykuł musi mieć długość od 100 do 100000 znaków!";
            }
            
            $no_html_content = strip_tags($content);
            $content_array = explode(" ", $no_html_content);
            foreach($content_array as $word)
            {
                if(strlen($word) > 60)// && preg_match('/[^><a-zA-Z\d]/', $word)
                {
                    $validation_OK = false;
                    $_SESSION['e_content'] = "Artykuł nie może zawierać ciągu znaków bez spacji powyżej 60! Tekst: ".substr($word, 0, 8)."...";;
                    break;
                }
            }    
            
            //Usuwanie wyrażeń regularnych, kwestia pytania ile takich niebezpiecznych jest.
            //Można wracać z informacją o usnięciu czegoś albo zablokować dostęp do konta.
            $count = 0;
            $vowels = array("<script>", "</script>", "onerror", "alert", "cookie", "kurwa", "chuj", "pierdol", "cipa", "dupa", "pizda");
            $content = str_replace($vowels, " ", $content, $count);
            if($count > 0)
            {
                $validation_OK = false;
                $_SESSION['e_content'] = "Znaleziono w treści $count wyrażenia niedozwolone!";
            }
        }
        //Walidacha nieudana, wracamy do edycji z zapamiętanymi danymi
        if($validation_OK == false) 
        {
            $_SESSION['mem_category_id'] = $category_id;
            $_SESSION['mem_title'] = $title;
            $_SESSION['mem_content'] = $content;
            if(isset($_POST['article_id'])) {header('location: freerte/examples/edycja_articles.php?article_id='.$_POST['article_id']);}
            else {header('location: freerte/examples/edycja_articles.php?article_id=new');}
            exit();
        }
        else
        {
            //ZAPIS DANYCH
            require_once 'config_db.php';
            if(isset($_POST['article_id']))//UPDATE istniejącego id
            {
                $article_id = htmlentities($_POST['article_id'], ENT_QUOTES, "UTF-8");	
                $result1 = mysqli_query($conn, 
                        sprintf("UPDATE `articles` SET `title` = '%s', `category_id` = '%d' WHERE `article_id` = '%d' AND user_id = '%d' LIMIT 1",
                        mysqli_real_escape_string($conn, $title),
                        mysqli_real_escape_string($conn, $category_id),
                        mysqli_real_escape_string($conn, $article_id),
                        mysqli_real_escape_string($conn, $_SESSION['user_id'])
                                ))
                or die("Błąd w articles.title: " . mysqli_error($conn));
                $r1 = mysqli_affected_rows($conn);

                $result2 = mysqli_query($conn,
                        sprintf("UPDATE `articles` SET `content` = '%s' WHERE `article_id` = '%d' AND user_id = '%d' LIMIT 1",
                        mysqli_real_escape_string($conn, $content),
                        mysqli_real_escape_string($conn, $article_id),
                        mysqli_real_escape_string($conn, $_SESSION['user_id'])
                                              ))
                or die("Błąd w articles.content: " . mysqli_error($conn));
                $r2 = mysqli_affected_rows($conn);

                if($r1 == 0 && $r2 == 0)
                {
                    echo'Nie dokonano żadnych zmian. Artykuł pozostał w niezmienionej formie.';
                }
                else
                {
                    echo'Artykuł został zaktualizowany.';
                }
            }//koniec UPDATE
            else //NOWY ARTYKUŁ bo brak ustawionego id
            {
                //sprawdzanie czy użytkonik ma już dodany i aktywny artykuł z dzisiejszą datą (max 1 dziennie można dodać)
                $result = mysqli_query($conn,
                    sprintf("SELECT * FROM `articles` WHERE `date`= CURDATE() AND `user_id` = '%d' AND stan = 1",
                    mysqli_real_escape_string($conn, $_SESSION['user_id'])
                                              ));
                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                $todays_art_number = mysqli_num_rows($result);
                if($todays_art_number > 0) $stan = 0; else $stan = 1;
                
                $result = mysqli_query($conn,
                    sprintf("INSERT INTO `articles` ( `article_id` , `title` , `content`,`date`, `stan`, `user_id`, `category_id`) VALUES (DEFAULT,'%s','%s',CURDATE(),'%d','%d','%d')",
                    mysqli_real_escape_string($conn, $title),
                    mysqli_real_escape_string($conn, $content),
                    mysqli_real_escape_string($conn, $stan),
                    mysqli_real_escape_string($conn, $_SESSION['user_id']),
                    mysqli_real_escape_string($conn, $category_id)
                                              ));
                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                else
                {
                    if($todays_art_number > 0)
                    {
                        echo'Artykuł został zapisany, jednak ponieważ '
                        . 'dodałeś już dzisiaj conajmniej 1 artykuł stan '
                        . 'będzie nieaktywny. Możesz aktywować od jutra.';
                    }
                    else
                    {
                        echo'Artykuł został dodany.';
                    }
  
                }
            }
        }	
     echo'	</main>
		
     </div>
	<!-- end content -->';
	
    }
}

$header_type = 2;
$show_content = true;
$show_sidebar = true; 

$article_save = new article_save($header_type, $show_content, $show_sidebar);

$article_save -> title = 'Kokpit';

$article_save -> keywords = 'kokpit';

$article_save -> description = 'kokpit';

$article_save -> Wyswietl();

?>
