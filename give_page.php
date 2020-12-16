<?php                            //zwraca content strony o id = parametr
header('Content-Type: text/html; charset=utf-8');
require 'config_db.php';
if($_GET["g"])
{
        $q=mysql_query('SELECT content FROM pages WHERE id_strona="'.$_GET["g"].'"');if($q != TRUE){echo 'B³ad zapytania MySQL, odpowiedŸ serwera: '.mysql_error();}
        $rekord=mysql_fetch_array($q);
        echo "<div>".$rekord["content"]."</div>";
}
?>
