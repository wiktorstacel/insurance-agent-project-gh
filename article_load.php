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
        $this->keywords = $words_comma;
        
        $this->description = $row[0];
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
                            sprintf("SELECT a.article_id, a.title, a.content, a.date, u.surname, u.user_id FROM articles a, users u WHERE a.user_id = u.user_id AND a.article_id = '%d' ORDER BY a.date DESC",
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
 
                //$this -> title = $row[1]; jak ustawić z tego miejsca title na poziomie klasy. ODP:$this -> setSomething($s);

                
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

$article_load = new article_load();

//$article_load -> title = 'Artykuł';

//$article_load -> keywords = 'ubezpieczenia, komunikacyjne, odszkodowania, rzeszów, podkarpackie';

//$article_load -> description = 'ubezpieczenia, odszkodowania';

$article_load -> Wyswietl();

?>
