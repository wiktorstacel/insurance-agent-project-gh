<?php

require_once ('strona_kokpit_stage.inc');

class page_save extends kokpit_stage
{
   public function WyswietlPage()
    {

        echo '
            <div id="content_kokpit">
                    <main style="margin-bottom: 20px;">';

        $title = htmlentities($_POST['title'], ENT_QUOTES, "UTF-8");
        $content = $_POST['freeRTE_content'];
    
        //WALIDACJA
        if(isset($_POST['submit']))
        {
            $validation_OK = true;
            
            if(strlen($title) < 3 || strlen($title) > 13)
            {
                $validation_OK = false;
                $_SESSION['e_title'] = "Tytuł musi mieć długość od 3 do 13 znaków!";
            }           
            elseif(!preg_match("/^(ą|ę| |ź|ć|ń|ó|&oacute;|ś|ż|ł|Ą|Ę|Ź|Ć|Ń|Ó|Ś|Ż|[0-9]|[a-z]|[A-Z]){3,13}$/", $title))
            {
                $validation_OK = false;
                $_SESSION['e_title'] = "Dozwolone tylko litery, cyfry i spacja!";
            }
            
            if(strlen($content) > 100000)
            {
                $validation_OK = false;
                $_SESSION['e_content'] = "Strona może zawierać do 100000 znaków!";
            }
            
            $no_html_content = strip_tags($content);
            $content_array = explode(" ", $no_html_content);
            $content_array = explode(" ", $content);
            foreach($content_array as $word)
            {
                if(strlen($word) > 60)// && preg_match('/[^"=:-#;><a-zA-Z\d]/',$word)
                {
                    $validation_OK = false;
                    $_SESSION['e_content'] = "Treść nie może zawierać ciągu znaków bez spacji powyżej 60! Tekst: ".substr($word, 0, 8)."...";
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
            $_SESSION['mem_title'] = $title;
            $_SESSION['mem_content'] = $content;
            if(isset($_POST['page_id'])) {header('location: freerte/examples/edycja_pages.php?page_id='.$_POST['page_id']);}
            else {header('location: freerte/examples/edycja_pages.php?page_id=new');}
            exit();
        }
        else
        {
        
            //ZAPIS DANYCH
            require_once 'config_db.php';
            //sprawdzenie czy zalogowany użytkownik ma uprawnienia
            $result = mysqli_query($conn, 
                    sprintf("SELECT * FROM `users` WHERE `perm`=1 AND `user_id`='%d'",
                    mysqli_real_escape_string($conn, $_SESSION['user_id'])
                            ));
            if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
            $record_number = mysqli_num_rows($result);
            if($record_number > 0)
            {
                if(isset($_POST['page_id']))//UPDATE istniejącego id
                {
                    $page_id = htmlentities($_POST['page_id'], ENT_QUOTES, "UTF-8");	

                    $result1 = mysqli_query($conn, 
                            sprintf("UPDATE `pages` SET `title` = '%s', `update_date` = CURDATE(), `user_id` = '%d', `stan` = 0 WHERE `page_id` = '%d' LIMIT 1",
                            mysqli_real_escape_string($conn, $title),
                            mysqli_real_escape_string($conn, $_SESSION['user_id']),
                            mysqli_real_escape_string($conn, $page_id)
                                    ))
                    or die("Błąd w pages.title: " . mysqli_error($conn));
                    $r1 = mysqli_affected_rows($conn);

                    $result2 = mysqli_query($conn,
                            sprintf("UPDATE `pages` SET `content` = '%s' WHERE `page_id` = '%d' LIMIT 1",
                            mysqli_real_escape_string($conn, $content),
                            mysqli_real_escape_string($conn, $page_id)
                                                  ))
                    or die("Błąd w pages.content: " . mysqli_error($conn));
                    $r2 = mysqli_affected_rows($conn);

                    if($r1 == 0 && $r2 == 0)
                    {
                        echo'Nie dokonano żadnych zmian. Zakładka pozostała w niezmienionej formie.';
                    }
                    else
                    {
                        echo'Strona został zaktualizowana. Aby była widoczna w serwisie potrzeba ją aktywować zmieniając STAN.';
                    }
                }//koniec UPDATE
                else //NOWY PAGE bo brak ustawionego id
                {
                    $result = mysqli_query($conn,
                        sprintf("INSERT INTO `pages` ( `page_id` , `title` , `content`, `update_date`, `user_id`, `stan`) VALUES (DEFAULT,'%s','%s',CURDATE(),'%d',0)",
                        mysqli_real_escape_string($conn, $title),
                        mysqli_real_escape_string($conn, $content),
                        mysqli_real_escape_string($conn, $_SESSION['user_id'])
                                                  ));
                    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                    else
                    {
                        echo'Strona została dodana.';
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

$page_save = new page_save($header_type, $show_content, $show_sidebar);

$page_save -> title = 'Kokpit';

$page_save -> keywords = 'kokpit';

$page_save -> description = 'kokpit';

$page_save -> Wyswietl();

?>
