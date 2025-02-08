<?php

require ('strona_kokpit_stage.php');

class kokpit_articleList extends kokpit_stage
{
    public function WyswietlPage()
    {

    echo '
    <div id="content_kokpit">
        <div style="margin-bottom: 20px;">';
        
        echo '<br>';
        echo "<table class='lista_art'>";
        echo "<tr class='listwa'>";
        echo'<td class="tytul">Tytuł artykułu</td>';
        echo'<td class="data">Data dodania</td>';
        echo '<td>W</td>';
        echo '<td>Podgląd</td>';
        echo'<td class="stan">Stan</td>';
        echo '<td>Edycja</td>';
        echo '<td>Usuń</td>';
        echo '</tr>';
        require 'config_db.php';
        if(!isset($_GET['articlesSum']))
        {
            $result = mysqli_query($conn, "SELECT * FROM articles ORDER BY date DESC LIMIT 10 OFFSET 0");
            $row_number = mysqli_num_rows($result);
        }
        else
        {
            $articlesSum = htmlentities($_GET['articlesSum'], ENT_QUOTES, "UTF-8");
            $result = mysqli_query($conn, 
                    sprintf("SELECT * FROM articles ORDER BY date DESC LIMIT 10 OFFSET %d",
                            mysqli_real_escape_string($conn, $articlesSum)
                            ));
        }
        if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);} 
        while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        {

            if($row[4] == 1)      //sprawdzanie czy wpis ma być wyswietlany jako aktywny
            {
                echo'<tr class="linia">';
            }
            else
            {
                echo'<tr class="linia2">';
            }
            echo'<td class="tytul">'.$row[1].'</td>';
            echo'<td class="data">'.$row[3].'</td>';
            echo'<td class="plus">'.$row[7].'</td>';
            echo'<td class="plus"><a href="article_preview.php?article_id='.$row[0].'">+</a></td>';
            if($row[5] == $_SESSION['user_id'])
            {
                echo'<td class="plus"><a href="article_stanChange.php?article_id='.$row[0].'&from=1">+</a></td>';
                echo'<td class="plus"><a href="freerte/examples/edycja_articles.php?article_id='.$row[0].'">+</a></td>';
            echo'<td class="plus"><a href="article_deleteConfirm.php?article_id='.$row[0].'">+</a></td>';
            }
            else
            {
                echo'<td class="plus"><u>+</u></td>';
                echo'<td class="plus"><u>+</u></td>';
                echo'<td class="plus"><u>+</u></td>';                
            }
            echo '</tr>';
        }
        echo '</table>';
        echo '<br>';

        if(!isset($_GET['articlesSum']))
        {
            
            $result = mysqli_query($conn, "SELECT * FROM articles ORDER BY date DESC LIMIT 1000000 OFFSET 0");
            $row_number = mysqli_num_rows($result);
            if($row_number > 10)
            {
                echo '<a href="kokpit_articlesList.php?articlesSum=10"><button style="float: right;" id="button_more_articles" class="btn btn-light">Dalej >></button></a>';
            }
        }
        else
        {
            $result_pom = mysqli_query($conn, 
            sprintf("SELECT * FROM articles ORDER BY date LIMIT 1000000 OFFSET %d",
                mysqli_real_escape_string($conn, $articlesSum)
                ));
            if($result_pom != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
            $row_number = mysqli_num_rows($result_pom);
            if($row_number > $articlesSum)
            {
                $articlesSum_10more = $articlesSum+10;
                $articlesSum_10less = $articlesSum-10;
                echo '<a href="kokpit_articlesList.php?articlesSum='.$articlesSum_10more.'"><button style="float: right;" id="button_more_articles" class="btn btn-light">Dalej >></button></a>';
                if($articlesSum >= 10)
                echo '<a href="kokpit_articlesList.php?articlesSum='.$articlesSum_10less.'"><button style="float: right; margin-right:6px;" id="button_more_articles" class="btn btn-light"><< Wstecz</button></a>';
            }
            else
            {
                $articlesSum_10less = $articlesSum-10;
                echo '<a href="kokpit_articlesList.php?articlesSum='.$articlesSum_10less.'"><button style="float: right; margin-right:6px;" id="button_more_articles" class="btn btn-light"><< Wstecz</button></a>';
            }
        }




    mysqli_close($conn);	
    echo'	</div>
        
    </div>
    <!-- end content_kokpit -->';
    }
}

$header_type = 2;
$show_content = true;
$show_sidebar = true; 

$kokpit_articlesList = new kokpit_articleList($header_type, $show_content, $show_sidebar);

$kokpit_articlesList -> title = 'Kokpit';

$kokpit_articlesList -> keywords = 'kokpit';

$kokpit_articlesList -> description = 'kokpit';

$kokpit_articlesList -> Wyswietl();

?>
