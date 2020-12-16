<?php


class kokpit_stage
{

   public function Wyswietl()
    {
      echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">';
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
 /*     $this -> WyswietlSearch();
      $this -> WyswietlMenuPion($this->przyciski_pion);
      $this -> WyswietlInformacje();
      $this -> WyswietlTresc();
//      echo $this->tresc;
      $this -> WyswietlStopke();
      $this -> WyswietlZastopke();*/
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
      print ("<meta name=\"keywords\" content=\"$this->keywords\" />\n");//Funkcja htmlentities powoduje zast¹pienie niedozwolonych znaków HTML-a na odpowiednie wartoœci, tzw. entities. Np. znak < zamienia na &lt; znak > na &gt; itd. Dziêki temu po dodaniu tekstu zawieraj¹cego takie znaki bêd¹ one widoczne na wygenerowanej stronie.
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
                  <meta http-equiv="Content-type" content="text/html; charset=ISO-8859-2"/>

                  <meta name="author" content="wiktor st¹cel" />
                  <meta http-equiv="reply-to" content="w-e@wp.pl" />
                  <meta name="copyright" content="Wiktor St¹cel" />

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
		<h1><a href="#">Kokpit</a></h1>
	</div>
	<div id="menu">
		<ul>
			<li class="active"><a href="index.html">Strona g³ówna</a></li>
		</ul>
	</div>
     </div>';
     echo '</div>';
    }

    public function WyswietlPage()
    {

    echo '<div id="page_kokpit">
	<div id="content_kokpit">
		<div style="margin-bottom: 20px;">';
		
        echo '<br>';
        echo "<table class='lista_art'>";
        echo "<tr class='listwa'>";
        print("<td class=\"tytul\">Tytu³</td>");
        print("<td class=\"data\">Data dodania</td>");
        print("<td class=\"stan\">Stan</td>");
        echo '<td>Podgl¹d</td>';
        echo '<td>Edycja</td>';
        echo '<td>Usuñ</td>';
        echo '</tr>';
        require 'config_db.php';
        $result = mysql_query("SELECT * FROM articles ORDER BY id DESC");
        while($row = mysql_fetch_array($result, MYSQL_NUM))
        {

                if($row[4] == 1)      //sprawdzanie czy wpis ma byæ wyswietlany jako aktywny
                    {
                    print("<tr class=\"linia\">");
                    }
                    else
                    {
                    print("<tr class=\"linia2\">");
                    }
                print("<td class=\"tytul\">$row[1]</td>");
                print("<td class=\"data\">$row[3]</td>");
                print("<td class=\"stan_linia\"><a href=\"aktywacja_wpisu.php?id=$row[0]\">+</a></td>");

                print("<td><a href=\"tekst.php?id=$row[0]\">+</a></td>");
                print("<td><a href=\"freerte/examples/edycja.php?id=$row[0]\">+</a></td>");
                print("<td><a href=\"del.php?id=$row[0]\">+</a></td>");
                echo '</tr>';
        }
         echo '</table>';
         echo '<br>';




		
	echo'	</div>
		
	</div>
	<!-- end content -->';
	}
	public function WyswietlSidebar()
	{
	
        echo'<div id="sidebar_kokpit">
		<div id="extra" class="boxed">
			<h2 class="title">Artyku³y</h2>
			<div class="content">
				<ul class="list">
					<li class="first"><a href="kokpit_stage.php">Lista artyku³ów</a></li>
					<li><a href="freerte/examples/edycja.php?id=new">Dodaj artyku³</a></li>
				</ul>
			</div>
		</div>
		<div id="extra" class="boxed">
			<h2 class="title">Strony</h2>
			<div class="content">
				<ul class="list">
					<li class="first"><a href="pages_list.php">Lista Stron</a></li>
					<li><a href="freerte/examples/edycja_pages.php?id=new">Dodaj stronê</a></li>
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
	<p id="links">Janina St¹cel. Wszelkie prawa zastrze¿one.</p>
	
		<div id="flash3">Aviva CU OFE</div>
                               <script type="text/javascript">
                               // <![CDATA[
                               window.scrollBy(0, 210);
                               flash("flash3", "blue", 20000, "aqua", 50);

                               // ]]>
                               </script>
	
     </div>';
    }
     
    }

?>
