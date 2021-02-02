<?php

class Strona2
{
    public $tresc;
    public $title;
    public $keywords;
    public $description;
    public $metas;
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
    public $stopka = 'Janina St&#261;cel Doradca Ubezpieczeniowy. &#169; 2003 - 2009. Wszelkie prawa zastrze�one.';

    public function _set($nazwa, $wartosc)
    {
      $this -> nazwa = $wartosc;
    }

    public function Wyswietl()
    {
      $this -> ObsluzSesje();
      echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">';
      echo "<html>\n<head>\n";
      $this -> WyswietlTytul();
      $this -> WyswietlSlowaKluczowe();
      $this -> WyswietlOpis();
      $this -> WyswietlMeta();
      $this -> WyswietlStyle();
      $this -> WyswietlSkrypty();
      echo "</head>\n<body>\n";
      $this -> WyswietlHeader();
      $this -> WyswietlPage();
      $this -> WyswietlSidebar();
      $this -> WyswietlFooter();
//      $this -> WyswietlMenuPoziom($this->przyciski_poz);
//      $this -> WyswietlSearch();
//      $this -> WyswietlMenuPion($this->przyciski_pion);
//      $this -> WyswietlInformacje();
//            $this -> WyswietlTresc();
//      echo $this->tresc;
//     $this -> WyswietlStopke();
//      $this -> WyswietlZastopke();
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
    
    function rewrite($string){ 
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
      echo '       <meta name="robots" content="index, follow">
                  <meta name="language" content="pl">
                  <meta http-equiv="Content-Language" content="pl">
                  <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>

                  <meta name="author" content="wiktor stącel" />
                  <meta http-equiv="reply-to" content="w-e@wp.pl" />
                  <meta name="copyright" content="Wiktor Stącel" />

                  <meta http-equiv="Content-Script-Type" content="text/javascript">
                  <base href="/" />';//SEO friendly URL 
      //so that every relative URL is resolved from that base URL and not from the current page's URL.
    }

    public function WyswietlStyle()
    {
      echo '<link rel="stylesheet" type="text/css" href="css/css_agent.css" />';
    }

    public function WyswietlSkrypty()
    {
        echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
        echo '<script language="JavaScript" type="text/javascript" src="js/js_agent.js"></script>';
        echo '<script language="JavaScript" type="text/javascript" src="js/jquery_agent.js"></script>';
        echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
    }

    public function WyswietlHeader()
    {
      echo '<div id="header_parent">';
      echo '<div id="header">
	<div id="logo">
		<h1><a href="index.php">Ubezpieczenia i Odszkodowania</a></h1>
		<h2><a href="index.php">informacje, artykuły, porady</a></h2>';//UWAGA: login i register !!!
	echo'</div>
	<div id="menu">
		<ul>';
                        require 'config_db.php';
                        $result = mysqli_query($conn, "SELECT * FROM pages WHERE stan=1 ORDER BY page_id ASC");
                        if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                        $count = 1;
                        $max = mysqli_num_rows($result);
                        while($row = mysqli_fetch_array($result, MYSQLI_NUM))
                        {
                            //echo'<li id="m'.$row[0].'" class="noactive"><a href="javascript:load_content(page_load.php?g='.$row[0].'), swiec('.$row[0].');">OFE</a></li>';
                            print("<li id=\"m".$count."\" class=\"noactive\"><a href=\"javascript:load_content('page_load.php?g=".$row[0]."'),swiec('".$count."', '".$max."');\">".$row[1]."</a></li>");
                            $count++;
                        }
                        //mysqli_close($conn);
			/*print("<li id=\"m1\" class=\"noactive\"><a href=\"javascript:load_content('page_load.php?g=1'),swiec('1');\">OFE</a></li>");
			print("<li id=\"m2\" class=\"noactive\"><a href=\"javascript:load_content('page_load.php?g=2'),swiec('2');\">Życie</a></li>");
			print("<li id=\"m3\" class=\"noactive\"><a href=\"javascript:load_content('page_load.php?g=3'),swiec('3');\">Mieszkanie</a></li>");
			print("<li id=\"m4\" class=\"noactive\"><a href=\"javascript:load_content('page_load.php?g=4'),swiec('4');\">Firma</a></li>");
			print("<li id=\"m5\" class=\"noactive\"><a href=\"javascript:load_content('page_load.php?g=5'),swiec('5');\">Auto</a></li>");
			print("<li id=\"m6\" class=\"noactive\"><a href=\"javascript:load_content('page_load.php?g=6'),swiec('6');\">Kontakt</a></li>");*/
     echo'	</ul>
	</div>
     </div>';
     echo '</div>';
    }
    
    public function WyswietlPage()
    {

    echo '<div id="page">
	<div id="content">
		<div style="margin-bottom: 20px;">';
			

  
              include 'config_db.php';
  
  
              $result = mysqli_query($conn, "SELECT a.article_id, a.title, a.content, a.date, u.surname FROM articles a, users u WHERE a.user_id = u.user_id AND a.stan=1 ORDER BY a.date DESC");
              if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
              //$row = mysqli_fetch_array($result, MYSQLI_NUM);
                while($row = mysqli_fetch_array($result, MYSQLI_NUM))
                {
                //$str_row_1 = str_replace(" ", "-", $row[1]);
                $sanitazed_title = $this->rewrite($row[1]);
        
                echo'<h1 class="title"><a href="article/'.$row[0].'/'.$sanitazed_title.'">'.$row[1].'</a></h1>';
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
                echo '<br /><br /><br />';
                }	
			
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
		</div>
	</div>
	<!-- end content -->';
	}
	public function WyswietlSidebar()
	{
	echo'<div id="sidebar">';
            echo'<div id="log_box">';
            if(isset($_SESSION['zalogowany']))
            {
                echo 'Zalogowany: '.$_SESSION['user'].' <br><a href="log_out.php">Wyloguj</a> - <a href="kokpit_articlesUser.php"> Tryb edycji</a>';
            }
            else                                
            {
                echo'<a href="login.php">Logowanie</a> / <a href="register.php">Rejestracja </a>';
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
						<h3>'.$row[3].'</h3>
						<p><a href="article/'.$row[0].'/'.$sanitazed_title.'">'.$row[1].'&hellip;</a></p>
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
	</div>
	<!-- end sidebar -->
	<div style="clear: both;">&nbsp;</div>
     </div>';//<!-- end of page (from WyswietlPage()) -->
    }
    
    public function WyswietlFooter()
    {
      echo '<div id="footer">
	<p id="legal">&copy;2015 Center Stage. All Rights Reserved. Designed by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a></p>
	<p id="links">Autor witryny: Wiktor Stącel, wiktor.stacel(at)hotmail.com. Wszelkie prawa zastrzeżone.</p>';
	
	/*echo'<div id="flash3"></div>
                               <!-- <script type="text/javascript">
                               // <![CDATA[
                               window.scrollBy(0, 210);
                               flash("flash3", "blue", 20000, "aqua", 50);

                               // ]]>
                               </script> --!>*/
		
        echo'<div class="cookie_container">';
            echo'Ta strona korzysta z ciasteczek aby świadczyć usługi na najwyższym poziomie. 
                Dalsze korzystanie ze strony oznacza, że zgadzasz się na ich użycie.&nbsp';
            echo'<button class="cookie_button">Zgoda</button>';
        echo'</div>';
 
     echo'</div>';
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

/*    public function WyswietlSearch()
    {
      echo '<div id="SEARCH">';
      echo '<form action="wyszukiwarka.php" method="GET">
            Wyszukaj: <br /><input id="tekst" style="width:150px;" name="q" onkeyup="podpowiedz(event)" autocomplete=off><button type="submit" value="Szukaj">OK</button>
            <div id="wyniki" class="wyniki"></div>
            </form>';
      echo '</div>';
    }  */

    public function WyswietlMenuPion($przyciski_pion)
    {
    echo '<div id="MENU">
	     <div>
             <ul class="kl2">';

            foreach($przyciski_pion as $nazwa => $url)
           {
                 $this -> WyswietlPrzyciskPion($nazwa, $url, !$this -> CzyToAktualnyURL($url));
           }
    echo '</ul>
             </div>
             

             <div id="KONTFORM" style="position:relative">
             <form action="http://fundusz-cu.comuf.com/kont.php" method="post" onsubmit="if (sprawdz1(this)) return true; return false">
                                <fieldset>
                               <legend>Zostaw kontakt -<strong>oddzwonie</strong></legend>
                               <p>imię i nazwisko: <input type="text" name="imiek" value="Jan Kowalski" size="12" maxlength="50" style="position: absolute; left: 129px; background-color: cornsilk; font-style: italic; color: gray "></p>
                                <p>nr telefonu: <input type="text" name="kontaktk" value size="12" maxlength="40" style="position: absolute; left:129px; background-color: cornsilk; font-style: italic; color: gray "></p>
                                <p align="left"><input type="submit" value="wy&#347;lij"/></p>
                                </fieldset>
             </form>
             </div>
             <div id="SMS">
             <a href="ubezpieczenia_lancut.htm" taget="">Ubezpieczenia �a�cut</a>
             <a href="ubezpieczenia_przeworsk.htm" taget="">Ubezpieczenia Przeworsk</a>
             <a href="ubezpieczenia_jaroslaw.htm" taget="">Ubezpieczenia Jaros�aw</a>
             <a href="ubezpieczenia_lezajsk.htm" taget="">Ubezpieczenia Le�ajsk</a>
             <a href="ubezpieczenia_sokolow_malopolski.htm" taget="">Soko��w Ma�opolski</a>
             <a href="ubezpieczenia_kolbuszowa.htm" taget="">Kolbuszowa</a>
             <a href="ubezpieczenia_zolynia.htm" taget="">Ubezpieczenia �o�ynia</a>
             <a href="ubezpieczenia_wola_zarczycka.htm" taget="">Wola �arczycka</a>
             <a href="ubezpieczenia_nowa_sarzyna.htm" taget="">Nowa Sarzyna</a>
             <a href="ubezpieczenia_sieniawa.htm" taget="">Sieniawa</a>
             <a href="ubezpieczenia_markowa.htm" taget="">Markowa</a>
             <a href="ubezpieczenia_tyczyn.htm" taget="">Tyczyn</a>
             <a href="ubezpieczenia_dynow.htm" taget="">Dyn�w</a>
             <a href="ubezpieczenia_strzyzow.htm" taget="">Strzy��w</a>
             <a href="ubezpieczenia_bratkowice.htm" taget="">Bratkowice</a>
             <a href="ubezpieczenia_rakszawa.htm" taget="">Ubezpieczenia Rakszawa</a>
             <a href="ubezpieczenia_kosina.htm" taget="">Ubezpieczenia Kosina</a>
             <a href="ubezpieczenia_krasne.htm" taget="">Ubezpieczenia Krasne</a>
             <a href="ubezpieczenia_swilcza.htm" taget="">Ubezpieczenia �wilcza</a>
             <a href="ubezpieczenia_debica.htm" taget="">Ubezpieczenia D�bica</a>
             <a href="ubezpieczenia_sedziszow_malopolski.htm" taget="">Sedzisz�w Ma�opolski</a>
             <a href="ubezpieczenia_ropczyce.htm" taget="">Ubezpieczenia Ropczyce</a>
             <a href="ubezpieczenia_boguchwala.htm" taget="">Boguchwa�a</a>
             <a href="aviva_rzeszow.htm" taget="">Aviva Rzesz�w</a>

             Losowanie OFE<br />Zapisy do CU OFE<br />Wy&#347;lij sms o tre&#347;ci "OFE" na numer 607 577 457  Podkarpackie,Fundusz Emerytalny Rzesz�w, �a�cut, Przeworsk, Le�ajsk, Jaros�aw i okolice. II filar, III filar, pierwsza praca, pierwsza wyp�ata, ranking funduszy emerytalnych 2009, najlepszy. stabilny, najwi�kszy, umowa, zapis, zapisy,<acronym>ZUS</acronym> Rzesz�w CU. Biuro Commercial Union Rzesz�w.
             <p><p align="justify">Nazywam si� Janina St&#261;cel i jestem doradc&#261; Commercial Union oddzia� w Rzeszowie.
             M�j obszar dzia�ania to ca�y kraj a w szczeg�lno�ci wojew�dztwo <b>Podkarpackie</b> - miasta mi�dzy innymi takie jak <b>Rzesz�w</b>, �a�cut, Przeworsk, Jaros�aw, Le�ajsk oraz okolice.
             Jeste&#347; zainteresowany - skontaktuj si�.</p>
               <div>
                             <br /><br />
             <p>Podj&#261;�e&#347; pierwsz&#261; prac�, DOSTA�E&#346; PIERWSZ&#260; WYP�AT�.
              Przyst�pienie do funduszu jest <u>obowi�zkowe</u> i <u>bezp�atne</u>.</p>

                        </div>
             </div>

             <div>

             <h1>commercial union rzesz�w</h1>

             </div>


        </div>';


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

    public function WyswietlInformacje()
    {
      echo '<div id="INFORMACJE">
                        <div><img height="400" alt="Janina St�cel kontakt telefon kom�rkowy gg" src="dane.jpg" width="200"></div>
                        <div id="OFERTA1">
                            <u>Aviva Commercial Union Rzesz�w</u>



                        </div>

                        <div>
                             <p><u>zapytaj doradc�w przez gg:</u></p>
                            <p><img src="http://status.gadu-gadu.pl/users/status.asp?id=10306775&amp;styl=0"><a href="gg:10306775">doradca ubez.</a><small>10306775</small></p>
                            <p><img src="http://status.gadu-gadu.pl/users/status.asp?id=10306775&amp;styl=0"><a href="gg:1925707">asystent OFE</a> <small>1925707</small></p>
                            <p><img src="http://status.gadu-gadu.pl/users/status.asp?id=10306775&amp;styl=0"><a href="gg:6299995">asystent OFE</a> <small>6299995</small></p></font>
                        </div>
                         <br />
                         <div id="flash3">Aviva CU OFE</div>
                               <script type="text/javascript">
                               // <![CDATA[
                               window.scrollBy(0, 210);
                               flash("flash3", "blue", 20000, "aqua", 50);

                               // ]]>
                               </script>


                </div>';
    }

    public function skaluj($szerokosc, $cel)        //je�eli szerokosc zdj jest mniejsza od maksymalnej, to zostawia oryginalny rozmiar
     {

         if($szerokosc > $cel)
         {
           $szerokosc = $cel;
         }
         echo "$szerokosc";
      }

    public function WyswietlTresc()
    {
      echo '<div id="TRESC">
                <div id="OBRAZKI"><img src="motyl.jpg" width="200" height="125" alt="Fundusz Emerytalny Rzesz�w OFE" /><img src="life.jpg" width="220" height="125" alt="Ubezpieczenia na �ycie maj�tkowe oraz Fundusz emerytalny Commercial Union OFE" /></div>
                <p><u>Dlaczego...</b> ?</u></p>Dlaczego jeste� na tej stronie? Czy dlatego, �e chcesz natychmiast zapisa� si� do konkretnego funduszu?
                Czy dlatego, �e cenisz okre�lon� mark�? Podejrzewam, �e nie...</p>
                <br /><p>Po prostu szukasz <b>pomys�u</b>, w miar� obiektywnej, ciekawej informacji o funduszach emerytalnych, aby przyst�pi� do takiego,
                kt�remu mo�na zaufa�. Chcesz omina� ca�� komercje, sprzeczne informacje i medialne sensacje oceiaj�ce OFE b�d� negatywnie, b�d� te�
                pozytywnie w zale�no�ci od pory dnia... </p>
                <br /><p>Jakby to by�o, by� w takim funduszu, kt�rym pieni�dze by�yby bezpieczene jak w zaufanym banku. Kiedy kompetencja,
                umiej�tno�ci i do�wiadczenie decyduj� o dobrym zarz�dzaniu.</p>
                <p>Ka�dy lubi mie� tak� �wiadomo��, �e kiedy na co dzie� wykonuje
                dobrze swoj� ci�k� prac�, to r�wnocze�nie gdzie� jest stabilne miejsce, gdzie jego pieni�dze, maj� zapewniony bezpieczny
                wzrost. Ka�dy ceni jasn�, przejrzyt� i klarown� sytuacj�, kiedy mo�e zaufa� doradcy, by� spokojnym i skupi� si� na swoich zadaniach.</p>
                <br /><p><i>Oczywi�cie taka sytuacja jest bardzo, bardzo po��dana i przez ostro�no�� nie wierzymy w takie opowie�ci. A co by by�o, gdyby
                takie rozwi�zania nie by�y dost�pne tylko dla nielicznych.</i></p>
                <br /><p>Inne fundusze te� maj� bardzo dobr� ofert�, ale skoro masz t� stron� pod r�k� to znajd� dla siebie przydatne informacje.
                Jak b�dziesz mia� czas to powiniene� tak�e spr�bowa� poszuka� oferty innych firm i doradc�w.</p>
                <p>Chcesz wi�cej informacji: uwa�nie czytaj dalej!
                <br /></p>




             <p><a href="commercial_union_ofe.htm">Wi�cej informacji o OFE</a><br />
             <a href="formularzofe.htm">Formularz przyst&#261;piena do Aviva OFE</a></p>

                </div>';

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

             //zwr�cenie kawalka kodu html z nowymi rozmiarami zdjecia

             echo "width=\"$szerokosc\" height=\"$wysokosc\"";
     }

    public function WyswietlStopke()
    {
      echo "<div id=\"STOPKA\">$this->stopka</div>";
    }
    
    public function WyswietlZastopke()
    {
      echo '<div id="ZASTOPKA">
	                        <div>';

                include( "robots_counter.php" );
                print '<img src="/robots_icon/google_logo.jpg" alt="google" /> <strong>'.$PageInfo['googlebot'].'</strong>  ';
                print '<img src="/robots_icon/msn_logo.jpg" alt="msn" /> <strong>'.$PageInfo['msnbot'].'</strong>  ';
                print '<img src="/robots_icon/yahoo_logo.jpg" alt="yahoo" /> <strong>'.$PageInfo['yahoo'].'</strong>';
                print '<img src="/robots_icon/net_logo.png" alt="netspring" /> <strong>'.$PageInfo['netspring'].'</strong>';
                print '<img src="/robots_icon/onet_logo.png" alt="onet" /> <strong>'.$PageInfo['onet'].'</strong>';
                print '<img src="/robots_icon/szukacz_logo.png" alt="szukacz" /> <strong>'.$PageInfo['szukacz'].'</strong>';

       echo'                        </div>


                <a href="http://www.rzeszow.pl/">Rzeszów</a>

                <a href="http://www.hosting.osemka.pl/">Darmowy hosting</a>';

                //<a href="http://skocz.com" title="Katalog Stron www" onclick="window.location='http://skocz.com/Polecajacy/53f9aa0c22c65822efd6c518bd64865f/'; return false;"><img src="http://skocz.com/pic/skocz.png" alt="Katalog Stron www" border="0" height="15" width="80" /></a>

        echo'        </div>

                <div id="AUTOR">autor strony-kontakt: w-e@wp.pl</div>';
    }

}
?>
