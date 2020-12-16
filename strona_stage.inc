<?php

class Strona2
{
    public $tresc;
    public $title;
    public $keywords;
    public $description;
    public $metas;
    public $przyciski_poz = array('Strona G��wna' => 'index.html',
                                  'zapisz si� do OFE on-line' => 'formularzofe.htm',
                                  'um�w spotkanie' => 'umowsp.htm'
                              );
    public $przyciski_pion = array('Fundusz Emerytalny OFE' => 'commercial_union_ofe.htm',
                                   'Ubezpieczenia Na �ycie' => 'ubezpieczenia_na_zycie.htm',
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

                  <meta name="author" content="wiktor st�cel" />
                  <meta http-equiv="reply-to" content="w-e@wp.pl" />
                  <meta name="copyright" content="Wiktor St�cel" />

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
		<h1><a href="#">Janina St�cel</a></h1>
		<h2><a href="#">Doradca Aviva</a></h2>
	</div>
	<div id="menu">
		<ul>';
			print("<li id=\"m1\" class=\"noactive\"><a href=\"javascript:give_content('give_page.php?g=1'),swiec('1');\">OFE</a></li>");
			print("<li id=\"m2\" class=\"noactive\"><a href=\"javascript:give_content('give_page.php?g=2'),swiec('2');\">�ycie</a></li>");
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
			

  
          require_once 'config_db.php';
  
  
              $result = mysqli_query($conn, "SELECT * FROM pages WHERE id_strona='1'");
              if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
              $row = mysqli_fetch_array($result, MYSQLI_NUM);

        
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
				<h3 class="title">CA�A OFERTA</h3>
				<ul class="list">
					<li><a href="#">Ubezpieczenia na �ycie</a></li>
					<li><a href="#">Fundusz Emerytalny</a></li>
					<li><a href="#">Ubezpieczenia maj�tkowe</a></li>
					<li><a href="#">Ubezpieczenia wyjazd�w zagranicznych</a></li>
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
			<h2 class="title">Artyku�y &amp; Promocje</h2>
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
	<p id="links">Janina St�cel. Wszelkie prawa zastrze�one.</p>
	
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
                               <p>imi� i nazwisko: <input type="text" name="imiek" value="Jan Kowalski" size="12" maxlength="50" style="position: absolute; left: 129px; background-color: cornsilk; font-style: italic; color: gray "></p>
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


                <a href="http://www.rzeszow.pl/">Rzesz�w</a>

                <a href="http://www.hosting.osemka.pl/">Darmowy hosting</a>';

                //<a href="http://skocz.com" title="Katalog Stron www" onclick="window.location='http://skocz.com/Polecajacy/53f9aa0c22c65822efd6c518bd64865f/'; return false;"><img src="http://skocz.com/pic/skocz.png" alt="Katalog Stron www" border="0" height="15" width="80" /></a>

        echo'        </div>

                <div id="AUTOR">autor strony-kontakt: w-e@wp.pl</div>';
    }

}
?>
