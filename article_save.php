<?php

require ('strona_kokpit_stage.inc');

class article_save extends kokpit_stage
{
    public function WyswietlPage()
    {
        echo '<div id="page_kokpit">
            <div id="content_kokpit">
                    <div style="margin-bottom: 20px;">';
        
        $title = htmlentities($_POST['title'], ENT_QUOTES, "UTF-8");
        $category_id = htmlentities($_POST['category_id'], ENT_QUOTES, "UTF-8");
        //$content = htmlentities($_POST['freeRTE_content'], ENT_QUOTES, "UTF-8");
        $content = $_POST['freeRTE_content'];
        
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
        }
        else //NOWY ARTYKUŁ bo brak ustawionego id
        {
            $result = mysqli_query($conn,
                sprintf("INSERT INTO `articles` ( `article_id` , `title` , `content`,`date`, `stan`, `user_id`, `category_id`) VALUES (DEFAULT,'%s','%s',CURDATE(),'1','%d','%d')",
                mysqli_real_escape_string($conn, $title),
                mysqli_real_escape_string($conn, $content),
                mysqli_real_escape_string($conn, $_SESSION['user_id']),
                mysqli_real_escape_string($conn, $category_id)
                                          ));
            if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
            else
            {
                echo'Artykuł został dodany.';
            }
        }
		
     echo'	</div>
		
     </div>
	<!-- end content -->';
	
    }
}


$article_save = new article_save();

$article_save -> title = 'Kokpit';

$article_save -> keywords = 'kokpit';

$article_save -> description = 'kokpit';

$article_save -> Wyswietl();

?>
