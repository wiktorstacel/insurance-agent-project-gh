<?php

class Strona2
{
    public $tresc;
    public $title;
    public $keywords;
    public $description;
    public $metas;
    protected $header_type;
    protected $show_content;
    protected $show_sidebar;
    protected $show_motto;
    public $przyciski_poz = array('Strona Główna' => 'index.html',
                                  'zapisz się do OFE on-line' => 'formularzofe.htm',
                                  'umów spotkanie' => 'umowsp.htm'
                              );
    public $przyciski_pion = array('Fundusz Emerytalny OFE' => 'commercial_union_ofe.htm',
                                   'Ubezpieczenia Na życie' => 'ubezpieczenia_na_zycie.htm',
                                   'Ubezpieczenia Komunikacyjne' => 'ubezpieczenia_komunikacyjne.htm',
                                   'Oferta' => 'oferta.htm',
                                   'Kim Jestem' => 'o_mnie.htm',
                                   'Kontakt' => 'kontakt.htm',
                                   'Ciekawe Linki' => 'linki.htm'
                              );
    public $stopka = 'Autor witryny: Wiktor Stącel, wiktor.stacel@hotmail.com. &copy;2021 Wszelkie prawa zastrzeżone.';
    
    public function __construct($header_type, $show_content, $show_sidebar, $show_motto) {
        $this->header_type = $header_type;
        $this->show_content = $show_content;
        $this->show_sidebar = $show_sidebar;
        $this->show_motto = $show_motto;
    }

    public function _set($nazwa, $wartosc)
    {
        $this -> nazwa = $wartosc;
    }

    public function Wyswietl()
    {
        $this -> ObsluzSesje();
        //echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">';
        echo '<!DOCTYPE html>';
        echo "<html>\n<head>\n";
            $this -> WyswietlTytul();
            $this -> WyswietlSlowaKluczowe();
            $this -> WyswietlOpis();
            $this -> WyswietlMeta();
            $this -> WyswietlStyle();
            $this -> WyswietlSkrypty();
        echo "</head>\n<body>\n";           
            $this -> WyswietlHeader();
            echo '<div id="page" class="container">';// 
            if($this -> show_content){$this -> WyswietlPage();}
            if($this -> show_sidebar)$this -> WyswietlSidebar();
            echo '<div style="clear: both;">&nbsp;</div></div>';//<!-- end of page (from WyswietlPage()) -->
            $this -> WyswietlFooter();
            //$this -> WyswietlMenuPoziom($this->przyciski_poz);

            echo '<script language="JavaScript" type="text/javascript" src="js/listeners_agent.js"></script>';
        echo "</body>\n</html>\n";
    }
    
    public function ObsluzSesje()
    {
        session_start();
        
        if(isset($_SESSION['zalogowany']))
        {
            //log out after 30 minuts of inactivity
            if(time() - $_SESSION['timestamp'] > 1500) //subtract new timestamp from the old one
            { 
                //echo"<script>alert('Wylogowano z powodu 30 minut braku aktywności!');</script>";
                unset($_SESSION['user'], $_SESSION['user_id'], $_SESSION['timestamp']);
                $_SESSION['zalogowany'] = false;
                header("Location: https://www.ubezpieczenia-odszkodowania.pl"); //redirect to index.php
                //<base href="/" /> - that in meta for friendly URL makes problem with redirection - to solve
            } 
            else 
            {
                $_SESSION['timestamp'] = time(); //set new timestamp
            }
        }
    }
    
    protected function rewrite($string)
    { 
        $a = array( 'Ę', 'Ó', 'Ą', 'Ś', 'Ł', 'Ż', 'Ź', 'Ć', 'Ń', 'ę', 'ó', 'ą',
                  'ś', 'ł', 'ż', 'ź', 'ć', 'ń' );
        $b = array( 'E', 'O', 'A', 'S', 'L', 'Z', 'Z', 'C', 'N', 'e', 'o', 'a',
                  's', 'l', 'z', 'z', 'c', 'n' );

        $string = str_replace("&oacute;", "o", $string );//2021-01-29: dodane, może tylko moja klawiatura daje to zamiast ó
        $string = str_replace( $a, $b, $string );
        $string = preg_replace( '#[^a-z0-9]#is', ' ', $string );
        $string = trim( $string );
        $string = preg_replace( '#\s{2,}#', ' ', $string );
        $string = str_replace( ' ', '-', $string );
        $string = strtolower($string);
        return $string;
    }

    public function WyswietlTytul()
    {
        echo '<meta name="verify-v1" content="TNJHeoK61VQS0o5RHL6ATlM5xAQS1jdwD34gtOl0LpI=" />
                   <meta name="y_key" content="d53f09aab117dc53">
                   <meta http-equiv="Content-Language" content="pl">';
        echo "<title> $this->title </title>\n";
    }

    public function WyswietlSlowaKluczowe()
    {
        print ("<meta name=\"keywords\" content=\"$this->keywords\" />\n");//Funkcja htmlentities powoduje zast�pienie niedozwolonych znak�w HTML-a na odpowiednie warto�ci, tzw. entities. Np. znak < zamienia na &lt; znak > na &gt; itd. Dzi�ki temu po dodaniu tekstu zawieraj�cego takie znaki b�d� one widoczne na wygenerowanej stronie.
    }

    public function WyswietlOpis()
    {
        print ("<meta name=\"description\" content=\"$this->description\" />\n");
    }

    public function WyswietlMeta()
    {
        echo '    <meta name="robots" content="index, follow">
                  <meta name="language" content="pl">
                  <meta http-equiv="Content-Language" content="pl">
                  <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>

                  <meta name="author" content="wiktor stącel" />
                  <meta http-equiv="reply-to" content="w-e@wp.pl" />
                  <meta name="copyright" content="Wiktor Stącel" />
                  
                  <meta charset="utf-8">
                  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

                  <meta http-equiv="Content-Script-Type" content="text/javascript">
                  <base href="/" />';//SEO friendly URL 
      //so that every relative URL is resolved from that base URL and not from the current page's URL.
    }

    public function WyswietlStyle()
    {
        echo '<link rel="stylesheet" type="text/css" href="css/css_agent.css" />';
        echo '<link rel="icon" type="image/png" sizes="16x16" href="/css/images/favicon.png">';
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">';
    }

    public function WyswietlSkrypty()
    {
        echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>';
        echo '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>';
        echo '<script language="JavaScript" type="text/javascript" src="js/js_agent.js"></script>';
        echo '<script language="JavaScript" type="text/javascript" src="js/jquery_agent.js"></script>';
        echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
        // Removed 'onload=onloadCallback' from url after form in contact_formLoad
        // In help it was written maybe this is also to add as global: window.myCallback = myCallback;
        ?>
        <!--[if lt IE 9]>
        <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/r29/html5.min.js"></script>
        <![endif]-->
        <?php
    }

    public function WyswietlHeader()
    {
        //echo '<div id="header_parent">';
        echo '<header id="header_parent">';
            echo '<div id="header">
                
                <div id="logo">

                        <h1><a href="index.php">Ubezpieczenia i Odszkodowania</a></h1>
                        <h4><a href="index.php">informacje, artykuły, porady</a></h4>';//UWAGA: login i register !!!
                echo'</div>
                    
                <div id="menu">
                    ';
                
                    
                        if($this->header_type === 1)
                        {?>
                            <nav class="navbar navbar-light navbar-expand-md order-last" id="navbar1">
                            <button class="navbar-toggler" id="navbarToggler1" onclick="changeMenuColor()" style="padding: 0px;" type="button" data-toggle="collapse" data-target="#main_menu" aria-expanded="false" aria-controls="main_menu" aria-label="przełącznik nawigacji">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            
                            <div class="collapse navbar-collapse" id="main_menu">
                            
                          <?php  
                            echo '<ul class="navbar-nav">';
                                require 'config_db.php';
                                
                                echo '<li class="noactive nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false" id="submenu" aria-haspopup="true"> Kategorie </a>
                                    <div class="dropdown-menu" aria-labelledby="submenu">';
                                
                                        $result = mysqli_query($conn, "SELECT * FROM artcategories ORDER BY name");
                                        if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}                        
                                        while($row = mysqli_fetch_array($result, MYSQLI_NUM))
                                        {       
                                            $sanitazed_name = $this->rewrite($row[1]);
                                            echo'<a class="dropdown-item" href="category/'.$row[0].'/'.$sanitazed_name.'">'.$row[1].'</a>';
                                        }
                                    
                                    echo'</div>
                                </li>';
                                
                                $result = mysqli_query($conn, "SELECT * FROM pages WHERE stan=1 ORDER BY page_id ASC");
                                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                                $count = 1;
                                $max = mysqli_num_rows($result);
                                while($row = mysqli_fetch_array($result, MYSQLI_NUM))
                                {
                                    print("<li id=\"m".$count."\" class=\"noactive nav-item\"><a class=\"nav-link\" href=\"javascript:load_content('page_load.php?g=".$row[0]."'),swiec('".$count."', '".$max."');\">".$row[1]."</a></li>");
                                    $count++;
                                }
                                //print("<li id=\"m".$count."\" class=\"noactive\"><a href=\"javascript:load_content('page_load.php?g=".$row[0]."'),swiec('".$count."', '".$max."');\">Kategorie</a></li>");
                            echo'</ul>';
                            echo '</div></nav>'; //end of main_menu
                        }
                        elseif($this->header_type === 2)
                        {
                            echo '<nav><ul>';
                                print("<li class=\"noactive\"><a style=\"color: white;\" href=\"index.php\">Powrót na stronę główną</a></li>");
                            echo'</ul></nav>';
                        }
                        elseif(($this->header_type === 3))
                        {
                            echo '<nav><ul>';
                                echo '<li class="active"><a href="../../kokpit_articlesUser.php">Powrót do kokpitu</a></li>';
                            echo'</ul></nav>';
                        }
                    
                        
                    echo '
                </div>
            </div>';//end of header
        echo '</header>';
        //echo '</div>';//end of header_parent
    }
    
    public function WyswietlMotto() 
    {
        echo '<div class="d-none d-md-block"><aside id="motto" style="margin-top: 100px;">
        <p style="text-align:justify;"><strong>Ubezpieczenia i Odszkodowania</strong> jest serwisem internetowym, w którym specjaliści, 
        dorardcy zamieszczają wartościowe artykuły związane z tematmi, z którymi pracuja na codzień. 
        Można znaleźć tutaj wartościowe informacje i porady, zapoznać się z trendami rynkowymi. 
        <em>Życzymy owocnego czytania :)</em></p>
        <br>
        <h2>Złote myśli</h2>
        <p>Zwycięzcy i ludzie sukcesu problemy traktują jako wyzwanie i szansę do własnego rozwoju i pomocy sobie i innym.</p>
        <blockquote>
                <p>&ldquo;Wiedza na temat tego, gdzie znaleźć informacje i jak je wykorzystać - to sekret sukcesu. &rdquo;Albert Einstein</p>
        </blockquote>
        </div>
        
        <div class="twocols">
            <div class="col1">';
                    echo'<h3 class="title">Jeśli jesteś doradcą</h3>
                    <p>...i chcesz współtworzyć ten serwis - załóż darmowe konto, które umożliwia pisanie artykułów, na końcu których znajduje się formularz przesyłający wiadomości od zainteresowanych osób bezpośrednio do na Twoją skrzynkę pocztową.</p>
                    <p><a href="regulamin.php">Regulamin&hellip;</a></p>                               
            </div>
            <div class="col2 d-none d-md-block">
                    <h3 class="title">WYBRANE KATEGORIE</h3>
                    <ul class="list">';
                    
                        include 'config_db.php';
                        $result = mysqli_query($conn, "SELECT * FROM artcategories ORDER BY RAND() LIMIT 5");
                        if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}                        
                        while($row = mysqli_fetch_array($result, MYSQLI_NUM))
                        {
                            $sanitazed_name = $this->rewrite($row[1]);
                            echo'<li class="first">
                                    <p><a href="category/'.$row[0].'/'.$sanitazed_name.'">'.$row[1].'</a></p>
                            </li>';
                        }

                    echo'</ul>
            </div>
        </div>';
        echo'</aside>';//end of motto
    }
    
    public function WyswietlPage()
    {
        echo '<div id="content" class="row">';
            echo'<main style="margin-bottom: 20px;">';	//MAIN		
  
            include 'config_db.php';
  
  
            $result = mysqli_query($conn, "SELECT a.article_id, a.title, a.content, a.date, u.surname FROM articles a, users u WHERE a.user_id = u.user_id AND a.stan=1 ORDER BY a.date DESC");
            if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
            //$row = mysqli_fetch_array($result, MYSQLI_NUM);
            while($row = mysqli_fetch_array($result, MYSQLI_NUM))
            {
                //$str_row_1 = str_replace(" ", "-", $row[1]);
                $sanitazed_title = $this->rewrite($row[1]);

                echo'<div class="col-sm-12"><article>';//
                echo'<header><h3 class="title"><a href="article/'.$row[0].'/'.$sanitazed_title.'">'.$row[1].'</a></h3></header>';
                echo '<br />';
                //echo $row[2];
                $no_html = strip_tags($row[2]);
                //echo substr($no_html, 0, 500);
                //Use wordwrap() to truncate the string without breaking words if the string is longer than 50 characters, and just add ... at the end
                if( strlen($no_html) > 600) {
                    $str = explode( "\n", wordwrap($no_html, 600));
                    $str = $str[0] . '...';
                    echo $str;
                }
                else
                {
                    echo $no_html;
                }
                echo'<a style="text-decoration: none;" href="article/'.$row[0].'/'.$sanitazed_title.'"> Czytaj dalej</a>';
                echo '<br /><br /><b>Autor:</b> '.$row[4].', '.$row[3];
                echo '<br /><br /><br /><br /><br /><br />';
                echo '</article></div>';
            }	
			
            
            echo'</main>';//END OF MAIN
        if($this->show_motto)$this->WyswietlMotto();
	echo'</div>
	<!-- end content -->';
    }
        
    public function WyswietlSidebar()
    {
	echo'<div id="sidebar" class="d-none d-lg-block"><aside>';
            echo'<div id="log_box">';
            if(isset($_SESSION['zalogowany']))
            {
                echo 'Zalogowany: '.$_SESSION['user'].' <br><a href="log_out.php">Wyloguj</a> - <a href="kokpit_articlesUser.php"> Tryb edycji</a>';
            }
            else                                
            {
                echo'<a href="login.php">Logowanie</a> / <a href="register.php">Rejestracja </a>';
                /*echo'<button class="btn-1234" value="1234" name="button_click_me">Click me</button>';*/
            }
            echo'</div><div style="clear: both;"></div>'; //end of log_box
            echo'
		<div id="search" class="boxed">
			<h2 class="title">Wyszukaj</h2>
			<div class="content">
				<form id="searchform" method="get" action="article_loadSearch.php">
					<fieldset>
					<input id="searchinput" type="text" name="searchinput" value="" />
					<input id="searchsubmit" type="submit" value="Szukaj" />
					</fieldset>
				</form>
                                <div id="suggestion_answer"></div>
			</div>
		</div>
		<div id="news" class="boxed">
			<h2 class="title">Artykuły &amp; Promocje</h2>
			<div class="content">
				<ul>';
            
                                    require 'config_db.php';
                                    $result = mysqli_query($conn, "SELECT a.article_id, a.title, a.content, DATE_FORMAT(a.date,'%Y-%m-%d') AS niceDate, u.surname FROM articles a, users u WHERE a.user_id = u.user_id AND a.stan=1 ORDER BY RAND() LIMIT 5");
                                    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}                        
                                    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
                                    {       
                                        $sanitazed_title = $this->rewrite($row[1]);
					echo'<li class="first">
						<p>'.$row[3].'</p>
						<p><a href="article/'.$row[0].'/'.$sanitazed_title.'">'.$row[1].'</a></p>
					</li>';
                                    }
				echo'</ul>
			</div>
		</div>
		<div id="extra" class="boxed">
			<h2 class="title">Kategorie artykułów</h2>
			<div class="content">
				<ul class="list">';
                                
                                    $result = mysqli_query($conn, "SELECT * FROM artcategories ORDER BY RAND()");
                                    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}                        
                                    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
                                    {       
                                        $sanitazed_name = $this->rewrite($row[1]);
					echo'<li class="first">
						<p><a href="category/'.$row[0].'/'.$sanitazed_name.'">'.$row[1].'</a></p>
					</li>';
                                    }
                                					
				echo'</ul>
			</div>
		</div>
	</aside></div>
	<!-- end sidebar -->';
    }
    
    public function WyswietlFooter()
    {
        //echo '<div id="footer" >'; //data-test="This is a test!" data-longer-name="TYTYTYTYZZZ"
        echo '<footer id="footer">';
        
            //echo '<p id="legal">&copy;2015 Center Stage. All Rights Reserved. Designed by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a></p>';
            echo '<p id="links">'.$this->stopka.'</p>';


            echo'<div class="cookie_container">';
                echo'Ta strona korzysta z ciasteczek aby świadczyć usługi na najwyższym poziomie. 
                    Dalsze korzystanie ze strony oznacza, że zgadzasz się na ich użycie.&nbsp';
                echo'<button class="cookie_button">Zgoda</button>';
            echo'</div>';
 
        echo '</footer>';
        //echo'</div>';
    }

    public function WyswietlMenuPoziom($przyciski_poz)
    {
      	echo '<div id="MENU_POZIOM">';
        echo '<ul class="kl1">';

        $szerokosc = 100/count($przyciski_poz);

        foreach($przyciski_poz as $nazwa => $url)
           {
                 $this -> WyswietlPrzyciskPoz($szerokosc, $nazwa, $url, !$this -> CzyToAktualnyURL($url));
           }

        echo '</ul>';
        echo '</div>';
    }

    public function CzyToAktualnyURL($url)
    {
        if(strpos($_SERVER['PHP_SELF'], $url)==false)  //strpos() sprawdza, czy podany URL jest w jednej z ustanowionych przez serwer zmiennych
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function WyswietlPrzyciskPoz($szerokosc, $nazwa, $url, $active=true)
    {
        if($active)
        {
            echo "<li style=\"width:".htmlentities($szerokosc)."%\"><a href = '".htmlentities($url)."'>$nazwa</a></li>\n";                  //width=".htmlentities($szerokosc)."%
        }
        else
        {
            echo "<li style=\"width:".htmlentities($szerokosc)."%\"><span class='menu'>$nazwa</span></li>";
        }
    } 

    public function WyswietlPrzyciskPion($nazwa, $url, $active=true)
    {
        if($active)
        {
            echo "<li><a href = '".htmlentities($url)."'>$nazwa</a></li>\n";                  //width=".htmlentities($szerokosc)."%
        }
        else
        {
            echo "<li><span class='menu'>$nazwa</span></li>";
        }
    }

    public function skaluj($szerokosc, $cel)        //jeżeli szerokosc zdj jest mniejsza od maksymalnej, to zostawia oryginalny rozmiar
    {
        if($szerokosc > $cel)
        {
            $szerokosc = $cel;
        }
        echo "$szerokosc";
    }

    public function zdjecieRozmiar($szerokosc, $wysokosc, $cel)
    {
        //funkcja z trzema argumentami (orginalna szerokosc, orginalna wysokosc, rozmiar doceolowy)
        if ($szerokosc > $wysokosc)
        {
            $procent = ($cel / $szerokosc);
        }
        else
        {
            $procent = ($cel / $wysokosc);
        }

        // zaokraglenie wartosci szerokosc i wysokosc
        $szerokosc = round($szerokosc * $procent);
        $wysokosc = round($wysokosc * $procent);

        //zwrócenie kawalka kodu html z nowymi rozmiarami zdjecia
        echo "width=\"$szerokosc\" height=\"$wysokosc\"";
    }

}
?>
