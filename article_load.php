<?php

require ('strona_stage.inc');

class article_load extends Strona2
{
    //Set class variables also keywords and description for each article instead of doing it down below
    function setTitle()
    {
        require 'config_db.php';
        $article_id = htmlentities($_GET['article_id'], ENT_QUOTES, "UTF-8");
        $result = mysqli_query($conn,
                    sprintf("SELECT a.title, a.content, u.surname FROM articles a, users u WHERE a.user_id = u.user_id AND a.article_id = '%d'",
                    mysqli_real_escape_string($conn, $article_id)
                        ));                
        if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
        $row = mysqli_fetch_array($result, MYSQLI_NUM);
        $this->title = $row[0];
        
        $pieces = explode(" ", $row[0]);
        $length = count($pieces);
        for ($i = 0; $i < $length; $i++) {
            if(strlen($pieces[$i]) < 4)
            {
                unset($pieces[$i]);//delete index, there are other function that reindex array - for implode() works
            }
        }
        $words_comma = implode(", ", $pieces);
        $vowels = array("!", "?", ".", "-"); //special character allowed for titles
        $words_comma = str_replace($vowels, " ", $words_comma);//delete characters sorrounding keywords
        $this->keywords = $words_comma;
        
        $this->description = $row[0];
        
        //view count
            $result = mysqli_query($conn,
            sprintf("UPDATE articles SET views = views + 1 WHERE article_id = '%d'",
            mysqli_real_escape_string($conn, $article_id)
                        ));                
            if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
        return true; 
    }
    
    public function WyswietlTytul()
    {
        echo '<meta name="verify-v1" content="TNJHeoK61VQS0o5RHL6ATlM5xAQS1jdwD34gtOl0LpI=" />
                     <meta name="y_key" content="d53f09aab117dc53">
                     <meta http-equiv="Content-Language" content="pl">';
        $this->setTitle();
        echo "<title> $this->title </title>\n";
    }
    
    public function WyswietlPage()
    {
      echo '<div id="page">
        <div id="content" style="float:left;">
            <div style="margin-bottom: 20px;">';
            
                //<!-- write content here -->
                require 'config_db.php';
                $article_id = htmlentities($_GET['article_id'], ENT_QUOTES, "UTF-8");
                $result = mysqli_query($conn,
                            sprintf("SELECT a.article_id, a.title, a.content, a.date, u.surname, u.user_id, a.views FROM articles a, users u WHERE a.user_id = u.user_id AND a.article_id = '%d' ORDER BY a.date DESC",
                            mysqli_real_escape_string($conn, $article_id)
                                ));                
                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                $row = mysqli_fetch_array($result, MYSQLI_NUM);
        
                echo'<h1 class="title">'.$row[1].'</h1>';
                echo '<br />';
                echo $row[2];
                echo '<br><br><b>Autor:</b> '.$row[4].', '.$row[3].', wyświetleń: '.$row[6];
                echo '<br /><br />';
                
                echo '<div class="user_profile_kontakt" id="kontaktform_div'.$row[5].'">';
                echo '<br><img src="css\images\envelop2.png" width="16" height="16" alt="alt"/>'
                . '<button class="kontaktform_loadButt" value="'.$row[5].'"> &nbspNapisz zapytanie o ofertę handlową lub spotkanie do autora...</button>';
                echo'</div>';
                echo'... lub wyszukaj kontakt do doradcy w Twojej okolicy w zakładce <u>Kontakt</u>';
                
                
                mysqli_close($conn);               
 
                //$this -> title = $row[1]; jak ustawić z tego miejsca title na poziomie klasy. ODP:$this -> setSomething($s);

                
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

$article_load = new article_load();

//$article_load -> title = 'Artykuł';

//$article_load -> keywords = 'ubezpieczenia, komunikacyjne, odszkodowania, rzeszów, podkarpackie';

//$article_load -> description = 'ubezpieczenia, odszkodowania';

$article_load -> Wyswietl();

?>
