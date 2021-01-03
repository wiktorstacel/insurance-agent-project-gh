<?php

require_once ('strona_kokpit_stage.inc');

class page_save extends kokpit_stage
{
   public function WyswietlPage()
    {

        echo '<div id="page_kokpit">
            <div id="content_kokpit">
                    <div style="margin-bottom: 20px;">';
		
        $title = htmlentities($_POST['title'], ENT_QUOTES, "UTF-8");
        $content = $_POST['freeRTE_content'];
    
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
                        sprintf("UPDATE `pages` SET `title` = '%s', `update_date` = CURDATE(), `user_id` = '%d', `stan` = 1 WHERE `page_id` = '%d' LIMIT 1",
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
                    echo'Strona został zaktualizowana.';
                }
            }
            else //NOWY PAGE bo brak ustawionego id
            {
                $result = mysqli_query($conn,
                    sprintf("INSERT INTO `pages` ( `page_id` , `title` , `content`, `update_date`, `user_id`, `stan`) VALUES (DEFAULT,'%s','%s',CURDATE(),'%d',1)",
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
     echo'	</div>
		
     </div>
	<!-- end content -->';
	
    }
}


$page_save = new page_save();

$page_save -> title = 'Kokpit';

$page_save -> keywords = 'kokpit';

$page_save -> description = 'kokpit';

$page_save -> Wyswietl();

?>
