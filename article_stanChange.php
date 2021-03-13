<?php

require ('strona_kokpit_stage.inc');

class article_stanChange extends kokpit_stage
{

    public function WyswietlPage()
    {

    echo '
	<div id="content_kokpit">
		<main style="margin-bottom: 20px;">';
    

                require_once 'config_db.php';
                $article_id = htmlentities($_GET['article_id'], ENT_QUOTES, "UTF-8");
                $from = $_GET['from'];
                
                //szukamy czy jest taki artykuł w bazie z id zalogowanego uzytkownika
                $result = mysqli_query($conn, 
                    sprintf("SELECT * FROM `articles` WHERE `article_id`='%d' AND `user_id`='%d'",
                    mysqli_real_escape_string($conn, $article_id),
                    mysqli_real_escape_string($conn, $_SESSION['user_id'])
                            ));
                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                $record_number = mysqli_num_rows($result);
                if($record_number > 0)
                {                    
                    $row = mysqli_fetch_array($result);
                    $article_stan = $row[4];
                    if($article_stan == 1)//(stan 1) i dezaktywujemy, to nie sprawdzamy więcej żadnych warunków
                    {
                        $result = mysqli_query($conn, 
                        sprintf("UPDATE `articles` SET `stan`= NOT stan WHERE `article_id`='%d' AND `user_id`='%d'",
                        mysqli_real_escape_string($conn, $article_id),
                        mysqli_real_escape_string($conn, $_SESSION['user_id'])
                                ));                                        
                        if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                        else//zmieniono stan - powrót do strony
                        {
                            if($from == 1) header('location: kokpit_articlesList.php');
                            elseif($from == 2) header('location: kokpit_articlesUser.php');
                        }
                    }
                    else //jak nieaktywny (stan 0) to sprawdzamy czy można aktywować
                    {
                        //sprawdzamy czy do aktywacji idzie stary artykuł czy dzisiajszy
                        $result = mysqli_query($conn, 
                        sprintf("SELECT * FROM `articles` WHERE date < CURDATE() AND `article_id`='%d'",
                        mysqli_real_escape_string($conn, $article_id)
                                ));
                        if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                        $old = mysqli_num_rows($result); // 1 to stary artykuł
                        //echo "czy stary: ".$old;exit();
                        //$article_date = strtotime($row[3]);//strtotime($var);
                        //$now = date();
                        //if($article_date < $now) {$old = 1;}
                        
                        //sprawdzamy liczbą aktywnych artykułów z dzisiejszą datą - tu można zwiększyć limit
                        $result = mysqli_query($conn, 
                        sprintf("SELECT COUNT(*) FROM `articles` WHERE date =CURDATE() AND `stan`=1 AND `user_id`='%d' GROUP BY user_id",
                        mysqli_real_escape_string($conn, $_SESSION['user_id'])
                                ));
                        if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                        $row = mysqli_fetch_array($result);
                        if($row[0] < 1 || $old == 1)//liczba aktywnych dzisiejszych < 1 lub aktywacja starego
                        {
                            $result = mysqli_query($conn, 
                            sprintf("UPDATE `articles` SET `stan`= NOT stan WHERE `article_id`='%d' AND `user_id`='%d'",
                            mysqli_real_escape_string($conn, $article_id),
                            mysqli_real_escape_string($conn, $_SESSION['user_id'])
                                    ));                                        
                            if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                            else//zmieniono stan - powrót do strony
                            {
                                if($from == 1) header('location: kokpit_articlesList.php');
                                elseif($from == 2) header('location: kokpit_articlesUser.php');
                            }
                        }
                        else //przekroczono dozwoloną liczbę aktywnych art dziennie, stan nie uległ zmianie
                        {
                            if($from == 1) header('location: kokpit_articlesList.php');
                            elseif($from == 2) header('location: kokpit_articlesUser.php');                        
                        }
                    }

                }
                else //użytkonik próbuje zmienić stan nie swojego artykułu
                {
                    echo 'Bład. Stan nie został zmieniony, spróbuj ponownie lub skontaktuj się z administratorem.';
                }
                mysqli_close($conn);
		
	echo'	</main>
		
	</div>
	<!-- end content -->';
    }

}

$header_type = 2;
$show_content = true;
$show_sidebar = true; 

$article_stanChange = new article_stanChange($header_type, $show_content, $show_sidebar);

$article_stanChange -> title = 'Kokpit';

$article_stanChange -> keywords = 'kokpit';

$article_stanChange -> description = 'kokpit';

$article_stanChange -> Wyswietl();

?>
