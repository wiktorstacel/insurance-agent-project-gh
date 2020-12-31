<?php

require ('strona_stage.inc');

class article_load extends Strona2
{
    
    public function WyswietlPage()
    {
      echo '<div id="page">
        <div id="content" style="float:left;">
            <div style="margin-bottom: 20px;">';
            
                //<!-- write content here -->
                require_once 'config_db.php';
                $article_id = htmlentities($_GET['article_id'], ENT_QUOTES, "UTF-8");
                $result = mysqli_query($conn, "SELECT a.article_id, a.title, a.content, a.date, u.surname FROM articles a, users u WHERE a.user_id = u.user_id AND a.article_id = $article_id ORDER BY a.date DESC");
                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                $row = mysqli_fetch_array($result, MYSQLI_NUM);
        
                echo'<h1 class="title"><a href="article_load.php?id='.$row[0].'">'.$row[1].'</a></h1>';
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
			<h2 class="title">Kategorie</h2>
			<div class="content">
				<ul class="list">
					<li class="first"><a href="#">Ut semper vestibulum est&hellip;</a></li>
					<li><a href="#">Vestibulum luctus venenatis&hellip;</a></li>
					<li><a href="#">Integer rutrum nisl in mi&hellip;</a></li>
				</ul>
			</div>
		</div>
	</div>
	<!-- end sidebar -->
	<div style="clear: both;">&nbsp;</div>
     </div>';//<!-- end of page (from WyswietlPage()) -->
    }
    

}

$article_load = new article_load();

$article_load -> title = '';

$article_load -> keywords = 'ubezpieczenia, komunikacyjne, odszkodowania, rzeszów, podkarpackie';

$article_load -> description = 'ubezpieczenia, odszkodowania';

$article_load -> Wyswietl();

?>
