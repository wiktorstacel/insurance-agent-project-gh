<?php

require ('strona_stage.inc');

class article_loadCategory extends Strona2
{
    
    public function WyswietlPage()
    {
      echo '<div id="page">
        <div id="content" style="float:left;">
            <div style="margin-bottom: 20px;">';
            
                //<!-- write content here -->
                require 'config_db.php';
                $category_id = htmlentities($_GET['category_id'], ENT_QUOTES, "UTF-8");
                $result = mysqli_query($conn,
                            sprintf("SELECT a.article_id, a.title, a.content, a.date, u.surname FROM articles a, users u, artcategories c WHERE a.user_id = u.user_id AND a.category_id = c.category_id AND c.category_id = '%d' ORDER BY a.date DESC",
                            mysqli_real_escape_string($conn, $category_id)
                                ));                
                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                if(mysqli_num_rows($result) < 1)
                {
                    echo'<h2 class="title">Brak artykułów w tej kategorii.</h2>';
                }
                else
                {
                    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
                    {
                    echo'<h1 class="title">'.$row[1].'</h1>';
                    echo '<br />';
                    echo $row[2];
                    echo '<br><br><b>Autor:</b> '.$row[4].', '.$row[3];
                    echo '<br /><br />';
                    }
                }
                mysqli_close($conn);
    

                
                
                        echo'	<br><br><br><p><strong>Ubezpieczenia i Odszkodowania</strong> jest serwisem internetowym zarejstrowanym w <a href="http://www.freecsstemplates.org/">Free CSS Templates</a> released under a <a href="http://creativecommons.org/licenses/by/2.5/">Creative Commons Attribution 2.5 License</a>. You"re free to use it for both commercial or personal use. I only ask that you link back to <a href="http://www.freecsstemplates.org/">my site</a> in some way. <em>Enjoy :)</em></p>
			<h2>Praesent Scelerisque</h2>
			<p>In posuere eleifend odio. Quisque semper augue mattis wisi. Maecenas ligula. Pellentesque viverra vulputate enim. Aliquam erat volutpat:</p>
			<blockquote>
				<p>&ldquo;Integer nisl risus, sagittis convallis, rutrum id, elementum congue, nibh. Suspendisse dictum porta lectus. Donec placerat odio vel elit. Nullam ante orci, pellentesque eget.&rdquo;</p>
			</blockquote>';
            echo'</div>
                

		<div>&nbsp;</div>
		<div class="twocols">
			<div class="col1">
				<h3 class="title">Lorem Ipsum Dolor</h3>
				<p>Donec leo, vivamus fermentum nibh in augue praesent a lacus at urna congue rutrum. Quisque dictum integer nisl risus, sagittis convallis, rutrum id, congue, and nibh.</p>
				<p><a href="#">Read more&hellip;</a></p>
			</div>
			<div class="col2">
				<h3 class="title">CAŁA OFERTA</h3>
				<ul class="list">
					<li><a href="#">Ubezpieczenia na Życie</a></li>
					<li><a href="#">Fundusz Emerytalny</a></li>
					<li><a href="#">Ubezpieczenia majątkowe</a></li>
					<li><a href="#">Ubezpieczenia wyjazdów zagranicznych</a></li>
					<li><a href="#">Ubezpieczenia dla firm</a></li>
				</ul>
			</div>
		</div>

        </div>'; //end of content
    }
    

}

$article_loadCategory = new article_loadCategory();

$article_loadCategory -> title = 'Artykuł';

$article_loadCategory -> keywords = 'ubezpieczenia, komunikacyjne, odszkodowania, rzeszów, podkarpackie';

$article_loadCategory -> description = 'ubezpieczenia, odszkodowania';

$article_loadCategory -> Wyswietl();

?>
