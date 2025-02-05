<?php

require ('strona_stage.php');

class page_preview extends Strona2
{
    
    public function WyswietlPage()
    {
      echo '
        <div id="content" style="float:left;">
            <div style="margin-bottom: 20px;">';
            
                //<!-- write content here -->
                require 'config_db.php';
                $page_id = htmlentities($_GET['page_id'], ENT_QUOTES, "UTF-8");
                $result = mysqli_query($conn,
                            sprintf("SELECT p.content, p.update_date, u.surname FROM pages p, users u WHERE p.user_id = u.user_id AND page_id = '%d'",
                            mysqli_real_escape_string($conn, $page_id)
                                ));
                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                $row = mysqli_fetch_array($result, MYSQLI_NUM);
        
                //echo'<h1 class="title">'.$row[1].'</h1>';
                echo '<br />';
                echo $row[0];
                echo '<br><br><b>Ostatnia aktualizacja:</b> '.$row[1].', '.$row[2];
                echo '<br /><br />';
                mysqli_close($conn);
                ?>                
                <script>
                    swiec(<?php echo $page_id?>);
                </script>
                <?php
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
	<!-- end sidebar -->';

    }
    

}

$header_type = 3;
$show_content = true;
$show_sidebar = true; 
$show_motto = false;

$page_preview = new page_preview($header_type, $show_content, $show_sidebar, $show_motto);

$page_preview -> title = 'Podglad strony';

$page_preview -> keywords = 'ubezpieczenia, komunikacyjne, odszkodowania, rzeszów, podkarpackie';

$page_preview -> description = 'ubezpieczenia, odszkodowania';

$page_preview -> Wyswietl();

?>




