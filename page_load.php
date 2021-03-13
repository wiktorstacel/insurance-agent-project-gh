<?php                            //zwraca content strony o id = parametr
//header('Content-Type: text/html; charset=utf-8');
require_once 'config_db.php';
$page_id = htmlentities($_GET['g'], ENT_QUOTES, "UTF-8");
if(isset($_GET['g']))
{
    $q = mysqli_query($conn, 
            sprintf("SELECT content FROM pages WHERE page_id='%d'",
            mysqli_real_escape_string($conn, $page_id)
                        ));
    if($q != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
    $rekord=mysqli_fetch_array($q);
    echo "<main><article>".$rekord["content"]."</article></main><br><br>";
}

//TREŚCI STALE PRZYPISANE DO ODPOWIEDNIEJ ZAKLADKI
echo '<div id="users_kontakt">';
if($page_id == 6)
{
    $result = mysqli_query($conn, "SELECT * FROM users ORDER BY RAND()");
    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
    while($row = mysqli_fetch_assoc($result))
    {
        echo '<section>';
        if(strlen($row['surname']) > 3)
        {
            //echo '<div class="user_profile_kontakt">';
            echo '<div class="user_profile_kontakt" id="kontaktform_div'.$row['user_id'].'">';//
            echo '<b>'.$row['surname'].'</b>';
            echo '<br>'.$row['address'];
            echo '<br><u>Telefon:</u> '.$row['tel_num'];
            echo '<br>'.$row['busi_area'];
            //print ("<br><a href=\"javascript:LoadForm('main_wyszukaj.php','field');\"> Napisz wiadomość</a>");
            //echo'<a><div class="kontaktform_class" value="'.$row['user_id'].'" name="'.$row['user_id'].'"> Napisz wiadomość</div></a>';
            //echo 'polski,'.$row['languages'].'</span>';
            echo'<br><img src="css\images\envelop2.png" width="16" height="16" alt="alt"/>'
            . '<button class="kontaktform_loadButt" value="'.$row['user_id'].'"> &nbspNapisz wiadomość</button>';


            //echo '</div>';
            echo'</div>';
        }
        echo '</section>';
    }
}
echo'</div>';
?>
