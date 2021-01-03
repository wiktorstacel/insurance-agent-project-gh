<?php

require ('strona_stage.inc');

class article_preview extends Strona2
{
    
    public function WyswietlPage()
    {
      echo '<div id="page">
        <div id="content" style="float:left;">
            <div style="margin-bottom: 20px;">';
            
                //<!-- write content here -->
                require 'config_db.php';
                $article_id = htmlentities($_GET['article_id'], ENT_QUOTES, "UTF-8");
                $result = mysqli_query($conn,
                            sprintf("SELECT a.article_id, a.title, a.content, a.date, u.surname FROM articles a, users u WHERE a.user_id = u.user_id AND a.article_id = '%d' ORDER BY a.date DESC",
                            mysqli_real_escape_string($conn, $article_id)
                                ));
                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                $row = mysqli_fetch_array($result, MYSQLI_NUM);
        
                echo'<h1 class="title">'.$row[1].'</h1>';
                echo '<br />';
                echo $row[2];
                echo '<br><br><b>Autor:</b> '.$row[4].', '.$row[3];
                echo '<br /><br />';
                mysqli_close($conn);
                


            echo'</div>';
        echo'</div>'; //end of content
    }
    
    	
	public function WyswietlSidebar()
	{
	echo'<div id="sidebar">';

            echo'

		<div id="extra" class="boxed">
			<h2 class="title">Kategorie artykułów</h2>
			<div class="content">
				<ul class="list">';
                                    
                                    require 'config_db.php';
                                    $result = mysqli_query($conn, "SELECT * FROM artcategories ORDER BY RAND()");
                                    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}                        
                                    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
                                    {       
					echo'<li class="first">
						<p>'.$row[1].'</p>
					</li>';
                                    }
                                    
				echo'</ul>
			</div>
		</div>
	</div>
	<!-- end sidebar -->
	<div style="clear: both;">&nbsp;</div>
     </div>';//<!-- end of page (from WyswietlPage()) -->
    }
    

}

$article_preview = new article_preview();

$article_preview -> title = '';

$article_preview -> keywords = 'ubezpieczenia, komunikacyjne, odszkodowania, rzeszów, podkarpackie';

$article_preview -> description = 'ubezpieczenia, odszkodowania';

$article_preview -> Wyswietl();

?>
