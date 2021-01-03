<?php                            //zwraca content strony o id = parametr
//header('Content-Type: text/html; charset=utf-8');
require_once 'config_db.php';
$page_id = htmlentities($_GET['g'], ENT_QUOTES, "UTF-8");
if(isset($_GET['g']))
{
    $q=mysqli_query($conn, 'SELECT content FROM pages WHERE page_id="'.$page_id.'"');
    if($q != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
    $rekord=mysqli_fetch_array($q);
    echo "<div>".$rekord["content"]."</div><br><br>";
}

//TREŚCI STALE PRZYPISANE DO ODPOWIEDNIEJ ZAKLADKI
if($page_id == 6)
{
    $result = mysqli_query($conn, "SELECT * FROM users ORDER BY RAND()");
    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
    while($row = mysqli_fetch_assoc($result))
    {
        echo '<div class="user_profile_kontakt">';
        
        echo '<b>'.$row['surname'].'</b>';
        echo '<br>'.$row['address'];
        echo '<br><u>Telefon:</u> '.$row['tel_num'];
        echo '<br>'.$row['busi_area'];
        echo '<br><a href="page_preview.php?page_id='.$row['user_id'].'"> Napisz wiadomość</a><span>';
        //echo 'polski,'.$row['languages'].'</span>';
        echo'</div>';
    }
}
?>
