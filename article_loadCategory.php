<?php

require ('strona_stage.php');

class article_loadCategory extends Strona2
{
    public function setTitle()
    {
        require 'config_db.php';
        $category_id = htmlentities($_GET['category_id'], ENT_QUOTES, "UTF-8");
        $result = mysqli_query($conn,
                    sprintf("SELECT name FROM artcategories WHERE category_id = '%d'",
                    mysqli_real_escape_string($conn, $category_id)
                        ));                
        if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
        else 
        {
            $row = mysqli_fetch_assoc($result);
            $this->title = $row['name'];
        }
    }
    
    public function WyswietlPage()
    {
      echo '
        <div id="content" class="row">
            <main style="margin-bottom: 20px;">';
            
                //<!-- write content here -->
                require 'config_db.php';
                $category_id = htmlentities($_GET['category_id'], ENT_QUOTES, "UTF-8");
                $result = mysqli_query($conn,
                            sprintf("SELECT a.article_id, a.title, a.content, a.date, u.surname, c.name FROM articles a, users u, artcategories c WHERE a.user_id = u.user_id AND a.category_id = c.category_id AND c.category_id = '%d' ORDER BY a.date DESC",
                            mysqli_real_escape_string($conn, $category_id)
                                ));                
                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                if(mysqli_num_rows($result) < 1)
                {
                    echo'<h3 class="title">Brak artykułów w tej kategorii.</h3>';
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
                        echo substr($no_html, 0, 500);
                        echo'<a style="text-decoration: none;" href="article/'.$row[0].'/'.$sanitazed_title.'"> ...Czytaj dalej</a>';
                        echo '<br><br><b>Autor:</b> '.$row[4].', '.$row[3];
                        echo '<br /><br /><br /><br />';
                        echo'</article></div>';
                    }

                }
                mysqli_close($conn);
    
              
		echo'</main>';
                if($this->show_motto)$this->WyswietlMotto();

        echo'</div>'; //end of content
    }
    

}

$header_type = 1;
$show_content = true;
$show_sidebar = true; 
$show_motto = false;

$article_loadCategory = new article_loadCategory($header_type, $show_content, $show_sidebar, $show_motto);

//$article_loadCategory -> title = 'Wybrana Kategoria';
$article_loadCategory->setTitle();

$article_loadCategory -> keywords = 'ubezpieczenia, komunikacyjne, odszkodowania, rzeszów, podkarpackie';

$article_loadCategory -> description = 'ubezpieczenia, odszkodowania';

$article_loadCategory -> Wyswietl();

?>
