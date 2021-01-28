<?php

require ('strona_stage.inc');

class article_loadSearch extends Strona2
{
    
    public function WyswietlPage()
    {
      echo '<div id="page">
        <div id="content" style="float:left;">
            <div style="margin-bottom: 20px;">';
            
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
                    echo'<h1 class="title">'.$row[1].'</h1>';
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
                        echo'<a style="text-decoration: none;" href="article_load.php?article_id='.$row[0].'"> ...Czytaj całość</a>';
                    }
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

$article_loadSearch = new article_loadSearch();

$article_loadSearch -> title = 'Artykuł';

$article_loadSearch -> keywords = 'ubezpieczenia, komunikacyjne, odszkodowania, rzeszów, podkarpackie';

$article_loadSearch -> description = 'ubezpieczenia, odszkodowania';

$article_loadSearch -> Wyswietl();

?>
