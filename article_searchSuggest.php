<?php

function rewrite($string){ 
  $a = array( 'Ę', 'Ó', 'Ą', 'Ś', 'Ł', 'Ż', 'Ź', 'Ć', 'Ń', 'ę', 'ó', 'ą',
              'ś', 'ł', 'ż', 'ź', 'ć', 'ń' );
  $b = array( 'E', 'O', 'A', 'S', 'L', 'Z', 'Z', 'C', 'N', 'e', 'o', 'a',
              's', 'l', 'z', 'z', 'c', 'n' );

      $string = str_replace("&oacute;", "o", $string );//2021-01-29: dodane, może tylko moja klawiatura daje to zamiast ó
      $string = str_replace( $a, $b, $string );
      $string = preg_replace( '#[^a-z0-9]#is', ' ', $string );
      $string = trim( $string );
      $string = preg_replace( '#\s{2,}#', ' ', $string );
      $string = str_replace( ' ', '-', $string );
      $string = strtolower($string);
      return $string;
}

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
        $sanitazed_title = rewrite($rekord['title']);
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
