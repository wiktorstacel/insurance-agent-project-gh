<?php

require ('strona_stage.php');

class article_loadSearch extends Strona2
{
    
    public function WyswietlPage()
    {
      echo '
        <div id="content" class="row">
            <main style="margin-bottom: 20px;">';
            
                //<!-- write content here -->
                require 'config_db.php';
                $article_search = htmlentities($_GET['searchinput'], ENT_QUOTES, "UTF-8");
                $article_search = mysqli_real_escape_string($conn, $article_search);
                $result=mysqli_query($conn, "SELECT a.article_id, a.title, a.content, a.date, u.surname FROM articles a, users u WHERE a.user_id = u.user_id AND (a.content LIKE '%$article_search%' OR a.title LIKE '%$article_search%') ORDER BY date DESC LIMIT 100");
                /*$result = mysqli_query($conn, "SELECT a.article_id, a.title, a.content, a.date, u.surname "
                        . "FROM articles a, users u, artcategories c "
                        . "WHERE a.title LIKE = '%$article_search%' ");*/
                        //. "AND a.user_id = u.user_id AND a.category_id = c.category_id "
                        //. "ORDER BY a.date DESC");                
                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                if(mysqli_num_rows($result) < 1)
                {
                    echo'<h2 class="title">Brak artykułów z wyszukiwaną frazą.</h2>';
                }
                else
                {
                    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
                    {
                    $sanitazed_title = $this->rewrite($row[1]);
                    echo'<div class="col-sm-12"><article>';
                    echo'<header><h3 class="title"><a href="article/'.$row[0].'/'.$sanitazed_title.'">'.$row[1].'</a></h3></header>';
                    echo '<br />';
                    $no_html = strip_tags($row[2]);
                    echo substr($no_html, 0, 900);
                    //Use wordwrap() to truncate the string without breaking words if the string is longer than 50 characters, and just add ... at the end
                    /*if( strlen($no_html) > 600) {
                        $str = explode( "\n", wordwrap($no_html, 600));
                        $str = $str[0] . '...';
                        echo $str;
                    }
                    else
                    {
                        echo $no_html;
                    }*/
                    if(strlen($no_html) > 900)
                    {
                        echo'<a style="text-decoration: none;" href="article/'.$row[0].'/'.$sanitazed_title.'"> ...Czytaj całość</a>';
                    }
                    echo '<br><br><b>Autor:</b> '.$row[4].', '.$row[3];
                    echo '<br /><br /><br /><br />';
                    echo'</article><div>';
                    }
                }
                mysqli_close($conn);
    

                
            echo'</main>'; //END OF MAIN
            if($this->show_motto)$this->WyswietlMotto();

        echo'</div>'; //end of content
    }
    

}

$header_type = 1;
$show_content = true;
$show_sidebar = true; 
$show_motto = false;

$article_loadSearch = new article_loadSearch($header_type, $show_content, $show_sidebar, $show_motto);

$article_loadSearch -> title = 'Wyniki wyszukiwania';

$article_loadSearch -> keywords = 'ubezpieczenia, komunikacyjne, odszkodowania, rzeszów, podkarpackie';

$article_loadSearch -> description = 'ubezpieczenia, odszkodowania';

$article_loadSearch -> Wyswietl();

?>
