<?php

require_once 'config_db.php';
$q=mysqli_query($conn, "SELECT title FROM articles ORDER BY title");
if($q != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
//$rekord=mysqli_fetch_assoc($q);


if(isset($_POST['suggestion']))
{
    $name = $_POST['suggestion'];
    while($rekord=mysqli_fetch_assoc($q))
    {
//            echo $rekord['title'];
//            echo "<br>";
//            echo strpos($rekord['title'], $name);
//            echo "<br>";
        if(strpos($rekord['title'], $name) !== false)
        {
            echo $rekord['title'];
            echo "<br>";
        }
    }
}


?>
