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
                    $no_html = strip_tags($row[2]);
                    echo substr($no_html, 0, 500);
                    echo'<a style="text-decoration: none;" href="article_load.php?article_id='.$row[0].'">...Czytaj dalej</a>';
                    echo '<br><br><b>Autor:</b> '.$row[4].', '.$row[3];
                    echo '<br /><br />';
                    }
                }
                mysqli_close($conn);
    

                
                
		echo'	<br><br><br><br><br><p><strong>Ubezpieczenia i Odszkodowania</strong> jest serwisem internetowym, w którym specjaliści, dorardcy zamieszczają wartościowe artykuły związane z tematmi, z którymi pracuja na codzień. Można znaleźć tutaj wartościowe informacje i porady, zapoznać się z trendami rynkowymi. <em>Życzymy owocnego czytania :)</em></p>
			<h2>Złote myśli</h2>
			<p>Zwycięzcy i ludzie sukcesu problemy traktują jako wyzwanie i szansę do własnego rozwoju i pomocy sobie i innym.</p>
			<blockquote>
				<p>&ldquo;Wiedza na temat tego, gdzie znaleźć informacje i jak je wykorzystać - to sekret sukcesu. &rdquo;Albert Einstein</p>
			</blockquote>
		</div>
		<div>&nbsp;</div>
		<div class="twocols">
			<div class="col1">';
				echo'<h3 class="title">Jeśłi jesteś doradcą</h3>
				<p>...i chcesz współtworzyć ten serwis - załóż darmowe konto, które umożliwia pisanie artykułów, na końcu których znajduje się formularz przesyłający wiadomości od zainteresowanych osób bezpośrednio do na Twoją skrzynkę pocztową.</p>
				<p><a href="regulamin.php">Regulamin&hellip;</a></p>                               
			</div>
			<div class="col2">
				<h3 class="title">WYBRANE KATEGORIE</h3>
				<ul class="list">';
                                    require 'config_db.php';
                                    $result = mysqli_query($conn, "SELECT * FROM artcategories ORDER BY RAND() LIMIT 5");
                                    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}                        
                                    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
                                    {       
					echo'<li class="first">
						<p><a href="article_loadCategory.php?category_id='.$row[0].'">'.$row[1].'</a></p>
					</li>';
                                    }
                                    
				echo'</ul>
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
