<?php

require ('strona_stage.inc');

class page_preview extends Strona2
{
    
    public function WyswietlPage()
    {
      echo '<div id="page">
        <div id="content" style="float:left;">
            <div style="margin-bottom: 20px;">';
            
                //<!-- write content here -->
                require_once 'config_db.php';
                $page_id = htmlentities($_GET['page_id'], ENT_QUOTES, "UTF-8");
                $result = mysqli_query($conn,
                            sprintf("SELECT * FROM pages WHERE page_id = '%d'",
                            mysqli_real_escape_string($conn, $page_id)
                                ));
                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                $row = mysqli_fetch_array($result, MYSQLI_NUM);
        
                //echo'<h1 class="title">'.$row[1].'</h1>';
                echo '<br />';
                echo $row[2];
                //echo '<br><br><b>Autor:</b> '.$row[4].', '.$row[3];
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

$page_preview = new page_preview();

$page_preview -> title = '';

$page_preview -> keywords = 'ubezpieczenia, komunikacyjne, odszkodowania, rzeszów, podkarpackie';

$page_preview -> description = 'ubezpieczenia, odszkodowania';

$page_preview -> Wyswietl();

?>
