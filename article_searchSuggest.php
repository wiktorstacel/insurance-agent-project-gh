<?php

require ('strona_stage.php');

if(isset($_POST['suggestion']) && $_POST['suggestion'] != NULL)
{
    $name = htmlentities($_POST['suggestion'], ENT_QUOTES, "UTF-8");
    require_once 'config_db.php';
    $name = mysqli_real_escape_string($conn, $name);
    $q=mysqli_query($conn, "SELECT article_id, title FROM articles WHERE title LIKE '%$name%' ORDER BY date DESC LIMIT 10");
    if($q != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
    //$rekord=mysqli_fetch_assoc($q);

    while($rekord=mysqli_fetch_assoc($q))
    {
        $sanitazed_title = Strona2::rewrite($rekord['title']); //Ważne: użycie metody statycznej bez tworzenia obiektu lub konieczności skopiowania funkcji rewrite($string) to tego pliku
        echo '<a style="color:inherit;" href="article/'.$rekord['article_id'].'/'.$sanitazed_title.'">'.$rekord['title'].'</a>';
        echo "<br>";
//            echo strpos($rekord['title'], $name);
//            echo "<br>";
        /*if(strpos($rekord['title'], $name) !== false)
        {
            echo $rekord['title'];
            echo "<br>";
        }*/
    }
}


?>
