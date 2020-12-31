<?php                            //zwraca content strony o id = parametr
header('Content-Type: text/html; charset=utf-8');
require_once 'config_db.php';
if($_GET["g"])
{
        $q=mysqli_query($conn, 'SELECT content FROM pages WHERE page_id="'.$_GET["g"].'"');
        if($q != TRUE){echo 'B�ad zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
        $rekord=mysqli_fetch_array($q);
        echo "<div>".$rekord["content"]."</div>";
}
?>
