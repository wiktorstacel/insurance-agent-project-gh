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
                                   'Ubezpieczenia Na Życie' => 'ubezpieczenia_na_zycie.htm',
                                   'Ubezpieczenia Komunikacyjne' => 'ubezpieczenia_komunikacyjne.htm',
                                   'Oferta' => 'oferta.htm',
                                   'Kim Jestem' => 'o_mnie.htm',
                                   'Kontakt' => 'kontakt.htm',
                                   'Ciekawe Linki' => 'linki.htm'
                              );
    public $stopka = 'Janina St&#261;cel Doradca Ubezpieczeniowy. &#169; 2003 - 2009. Wszelkie prawa zastrzeżone.';

    public function _set($nazwa, $wartosc)
    {
      $this -> nazwa = $wartosc;
    }

    public function Wyswietl()
    {
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
//      $this -> WyswietlTresc();
//      echo $this->tresc;
//     $this -> WyswietlStopke();
//      $this -> WyswietlZastopke();
      echo "</body>\n</html>\n";

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
      print ("<meta name=\"keywords\" content=\"$this->keywords\" />\n");//Funkcja htmlentities powoduje zast±pienie niedozwolonych znaków HTML-a na odpowiednie warto¶ci, tzw. entities. Np. znak < zamienia na &lt; znak > na &gt; itd. Dzięki temu po dodaniu tekstu zawieraj±cego takie znaki będ± one widoczne na wygenerowanej stronie.
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
                  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

                  <meta name="author" content="wiktor st±cel" />
                  <meta http-equiv="reply-to" content="w-e@wp.pl" />
                  <meta name="copyright" content="Wiktor St±cel" />

                  <meta http-equiv="Content-Script-Type" content="text/javascript">';
    }

    public function WyswietlStyle()
    {
      echo "<link rel=\"Stylesheet\" type=\"text/css\" href=\"default.css\" />\n";
    }

    public function WyswietlSkrypty()
    {
      echo '<script language="JavaScript" type="text/javascript" src="javascryptfundusz.js"></script>';
    }

    public function WyswietlHeader()
    {
      echo '<div id="header_parent">';
      echo '<div id="header">
	<div id="logo">
		<h1><a href="#">Janina St±cel</a></h1>
		<h2><a href="#">Doradca Aviva</a></h2>
	</div>
	<div id="menu">
		<ul>';
			print("<li id=\"m1\" class=\"noactive\"><a href=\"javascript:give_content('give_page.php?g=1'),swiec('1');\">OFE</a></li>");
			print("<li id=\"m2\" class=\"noactive\"><a href=\"javascript:give_content('give_page.php?g=2'),swiec('2');\">Życie</a></li>");
			print("<li id=\"m3\" class=\"noactive\"><a href=\"javascript:give_content('give_page.php?g=3'),swiec('3');\">Mieszkanie</a></li>");
			print("<li id=\"m4\" class=\"noactive\"><a href=\"javascript:give_content('give_page.php?g=4'),swiec('4');\">Firma</a></li>");
			print("<li id=\"m5\" class=\"noactive\"><a href=\"javascript:give_content('give_page.php?g=5'),swiec('5');\">Auto</a></li>");
			print("<li id=\"m6\" class=\"noactive\"><a href=\"javascript:give_content('give_page.php?g=6'),swiec('6');\">Kontakt</a></li>");
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
			

  
          require('config_db.php');
  
  
              $result = mysql_query("SELECT * FROM pages WHERE id_strona='1'");
              if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedĽ serwera: '.mysql_error();}
              $row = mysql_fetch_array($result, MYSQL_NUM);

        
                print("<h1 class=\"title\">$row[1]</h1>");
                print("$row[2]");
            		
			
		echo'	<p><strong>Center Stage</strong> is a free template from <a href="http://www.freecsstemplates.org/">Free CSS Templates</a> released under a <a href="http://creativecommons.org/licenses/by/2.5/">Creative Commons Attribution 2.5 License</a>. You"re free to use it for both commercial or personal use. I only ask that you link back to <a href="http://www.freecsstemplates.org/">my site</a> in some way. <em>Enjoy :)</em></p>
			<h2>Praesent Scelerisque</h2>
			<p>In posuere eleifend odio. Quisque semper augue mattis wisi. Maecenas ligula. Pellentesque viverra vulputate enim. Aliquam erat volutpat:</p>
			<blockquote>
				<p>&ldquo;Integer nisl risus, sagittis convallis, rutrum id, elementum congue, nibh. Suspendisse dictum porta lectus. Donec placerat odio vel elit. Nullam ante orci, pellentesque eget.&rdquo;</p>
			</blockquote>
		</div>
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
					<li><a href="#">Ubezpieczenia na życie</a></li>
					<li><a href="#">Fundusz Emerytalny</a></li>
					<li><a href="#">Ubezpieczenia maj±tkowe</a></li>
					<li><a href="#">Ubezpieczenia wyjazdów zagranicznych</a></li>
					<li><a href="#">Ubezpieczenia dla firm</a></li>
				</ul>
			</div>
		</div>
	</div>
	<!-- end content -->';
	}
	public function WyswietlSidebar()
	{
	echo'<div id="sidebar">
		<div id="search" class="boxed">
			<h2 class="title">Wyszukaj</h2>
			<div class="content">
				<form id="searchform" method="get" action="">
					<fieldset>
					<input id="searchinput" type="text" name="searchinput" value="" />
					<input id="searchsubmit" type="submit" value="Szukaj" />
					</fieldset>
				</form>
			</div>
		</div>
		<div id="news" class="boxed">
			<h2 class="title">Artykuły &amp; Promocje</h2>
			<div class="content">
				<ul>
					<li class="first">
						<h3>04 July 2007</h3>
						<p><a href="#">In posuere eleifend odio quisque semper&hellip;</a></p>
					</li>
					<li>
						<h3>29 June 2007</h3>
						<p><a href="#">Donec leo, vivamus fermentum nibh in augue&hellip;</a></p>
					</li>
					<li>
						<h3>13 June 2007</h3>
						<p><a href="#">Quisque dictum integer nisl risus sagittis&hellip;</a></p>
					</li>
				</ul>
			</div>
		</div>
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
     </div>';
    }
    
    public function WyswietlFooter()
    {
      echo '<div id="footer">
	<p id="legal">&copy;2007 Center Stage. All Rights Reserved. Designed by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a></p>
	<p id="links">Janina St±cel. Wszelkie prawa zastrzeżone.</p>
	
	<div id="flash3">Aviva CU OFE</div>
                               <script type="text/javascript">
                               // <![CDATA[
                               window.scrollBy(0, 210);
                               flash("flash3", "blue", 20000, "aqua", 50);

                               // ]]>
                               </script>
	
     </div>';
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
             <a href="ubezpieczenia_lancut.htm" taget="">Ubezpieczenia Łańcut</a>
             <a href="ubezpieczenia_przeworsk.htm" taget="">Ubezpieczenia Przeworsk</a>
             <a href="ubezpieczenia_jaroslaw.htm" taget="">Ubezpieczenia Jarosław</a>
             <a href="ubezpieczenia_lezajsk.htm" taget="">Ubezpieczenia Leżajsk</a>
             <a href="ubezpieczenia_sokolow_malopolski.htm" taget="">Sokołów Małopolski</a>
             <a href="ubezpieczenia_kolbuszowa.htm" taget="">Kolbuszowa</a>
             <a href="ubezpieczenia_zolynia.htm" taget="">Ubezpieczenia Żołynia</a>
             <a href="ubezpieczenia_wola_zarczycka.htm" taget="">Wola Żarczycka</a>
             <a href="ubezpieczenia_nowa_sarzyna.htm" taget="">Nowa Sarzyna</a>
             <a href="ubezpieczenia_sieniawa.htm" taget="">Sieniawa</a>
             <a href="ubezpieczenia_markowa.htm" taget="">Markowa</a>
             <a href="ubezpieczenia_tyczyn.htm" taget="">Tyczyn</a>
             <a href="ubezpieczenia_dynow.htm" taget="">Dynów</a>
             <a href="ubezpieczenia_strzyzow.htm" taget="">Strzyżów</a>
             <a href="ubezpieczenia_bratkowice.htm" taget="">Bratkowice</a>
             <a href="ubezpieczenia_rakszawa.htm" taget="">Ubezpieczenia Rakszawa</a>
             <a href="ubezpieczenia_kosina.htm" taget="">Ubezpieczenia Kosina</a>
             <a href="ubezpieczenia_krasne.htm" taget="">Ubezpieczenia Krasne</a>
             <a href="ubezpieczenia_swilcza.htm" taget="">Ubezpieczenia ¦wilcza</a>
             <a href="ubezpieczenia_debica.htm" taget="">Ubezpieczenia Dębica</a>
             <a href="ubezpieczenia_sedziszow_malopolski.htm" taget="">Sedziszów Małopolski</a>
             <a href="ubezpieczenia_ropczyce.htm" taget="">Ubezpieczenia Ropczyce</a>
             <a href="ubezpieczenia_boguchwala.htm" taget="">Boguchwała</a>
             <a href="aviva_rzeszow.htm" taget="">Aviva Rzeszów</a>

             Losowanie OFE<br />Zapisy do CU OFE<br />Wy&#347;lij sms o tre&#347;ci "OFE" na numer 607 577 457  Podkarpackie,Fundusz Emerytalny Rzeszów, Łańcut, Przeworsk, Leżajsk, Jarosław i okolice. II filar, III filar, pierwsza praca, pierwsza wypłata, ranking funduszy emerytalnych 2009, najlepszy. stabilny, największy, umowa, zapis, zapisy,<acronym>ZUS</acronym> Rzeszów CU. Biuro Commercial Union Rzeszów.
             <p><p align="justify">Nazywam się Janina St&#261;cel i jestem doradc&#261; Commercial Union oddział w Rzeszowie.
             Mój obszar działania to cały kraj a w szczególno¶ci województwo <b>Podkarpackie</b> - miasta między innymi takie jak <b>Rzeszów</b>, Łańcut, Przeworsk, Jarosław, Leżajsk oraz okolice.
             Jeste&#347; zainteresowany - skontaktuj się.</p>
               <div>
                             <br /><br />
             <p>Podj&#261;łe&#347; pierwsz&#261; pracę, DOSTAŁE&#346; PIERWSZ&#260; WYPŁATĘ.
              Przyst±pienie do funduszu jest <u>obowi±zkowe</u> i <u>bezpłatne</u>.</p>

                        </div>
             </div>

             <div>

             <h1>commercial union rzeszów</h1>

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
                        <div><img height="400" alt="Janina St±cel kontakt telefon komórkowy gg" src="dane.jpg" width="200"></div>
                        <div id="OFERTA1">
                            <u>Aviva Commercial Union Rzeszów</u>



                        </div>

                        <div>
                             <p><u>zapytaj doradców przez gg:</u></p>
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

    public function skaluj($szerokosc, $cel)        //jeżeli szerokosc zdj jest mniejsza od maksymalnej, to zostawia oryginalny rozmiar
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
                <div id="OBRAZKI"><img src="motyl.jpg" width="200" height="125" alt="Fundusz Emerytalny Rzeszów OFE" /><img src="life.jpg" width="220" height="125" alt="Ubezpieczenia na życie maj±tkowe oraz Fundusz emerytalny Commercial Union OFE" /></div>
                <p><u>Dlaczego...</b> ?</u></p>Dlaczego jeste¶ na tej stronie? Czy dlatego, że chcesz natychmiast zapisać się do konkretnego funduszu?
                Czy dlatego, że cenisz okre¶lon± markę? Podejrzewam, że nie...</p>
                <br /><p>Po prostu szukasz <b>pomysłu</b>, w miarę obiektywnej, ciekawej informacji o funduszach emerytalnych, aby przyst±pić do takiego,
                któremu można zaufać. Chcesz ominać cał± komercje, sprzeczne informacje i medialne sensacje oceiaj±ce OFE b±dĽ negatywnie, b±dĽ też
                pozytywnie w zależno¶ci od pory dnia... </p>
                <br /><p>Jakby to było, być w takim funduszu, którym pieni±dze byłyby bezpieczene jak w zaufanym banku. Kiedy kompetencja,
                umiejętno¶ci i do¶wiadczenie decyduj± o dobrym zarz±dzaniu.</p>
                <p>Każdy lubi mieć tak± ¶wiadomo¶ć, że kiedy na co dzień wykonuje
                dobrze swoj± ciężk± pracę, to równocze¶nie gdzie¶ jest stabilne miejsce, gdzie jego pieni±dze, maj± zapewniony bezpieczny
                wzrost. Każdy ceni jasn±, przejrzyt± i klarown± sytuację, kiedy może zaufać doradcy, być spokojnym i skupić się na swoich zadaniach.</p>
                <br /><p><i>Oczywi¶cie taka sytuacja jest bardzo, bardzo poż±dana i przez ostrożno¶ć nie wierzymy w takie opowie¶ci. A co by było, gdyby
                takie rozwi±zania nie były dostępne tylko dla nielicznych.</i></p>
                <br /><p>Inne fundusze też maj± bardzo dobr± ofertę, ale skoro masz t± stronę pod ręk± to znajdĽ dla siebie przydatne informacje.
                Jak będziesz miał czas to powiniene¶ także spróbować poszukać oferty innych firm i doradców.</p>
                <p>Chcesz więcej informacji: uważnie czytaj dalej!
                <br /></p>




             <p><a href="commercial_union_ofe.htm">Więcej informacji o OFE</a><br />
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

             //zwrócenie kawalka kodu html z nowymi rozmiarami zdjecia

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
