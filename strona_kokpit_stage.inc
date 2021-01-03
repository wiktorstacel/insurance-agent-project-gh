<?php


class kokpit_stage
{

   public function Wyswietl()
    {
      $this -> ObsluzSesje();
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
 /*   $this -> WyswietlSearch();
      $this -> WyswietlMenuPion($this->przyciski_pion);
      $this -> WyswietlInformacje();
      $this -> WyswietlTresc();
      echo $this->tresc;
      $this -> WyswietlStopke();
      $this -> WyswietlZastopke();*/
      echo "</body>\n</html>\n";
    }
    
    public function ObsluzSesje()
    {
        session_start();
        if(!isset($_SESSION['zalogowany']))
        {
            header('location: login.php');
            exit();
        }
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

                  <meta http-equiv="Content-Script-Type" content="text/javascript">';
    }

    public function WyswietlStyle()
    {
      echo "<link rel=\"Stylesheet\" type=\"text/css\" href=\"css/css_agent.css\" />\n";
    }

    public function WyswietlSkrypty()
    {
        echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
        echo '<script language="JavaScript" type="text/javascript" src="js/js_agent.js"></script>';
        echo '<script language="JavaScript" type="text/javascript" src="js/jquery_agent.js"></script>';
    }

   public function WyswietlHeader()
    {
      echo '<div id="header_parent">';
      echo '<div id="header">
	<div id="logo">
		<h1><a href="#">Zarządzanie treścią witryny</a></h1>
	</div>
	<div id="menu">
		<ul>
			<li class="active"><a href="index.php">Powrót na strona główną</a></li>
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
        echo'<td class="tytul">Tytuł artykułu</td>';
        echo'<td class="data">Data dodania</td>';
        echo '<td>Podgląd</td>';
        echo'<td class="stan">Stan</td>';
        echo '<td>Edycja</td>';
        echo '<td>Usuń</td>';
        echo '</tr>';
        require_once 'config_db.php';
        $result = mysqli_query($conn, "SELECT * FROM articles ORDER BY date DESC");
        if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);} 
        while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        {

            if($row[4] == 1)      //sprawdzanie czy wpis ma być wyswietlany jako aktywny
            {
                echo'<tr class="linia">';
            }
            else
            {
                echo'<tr class="linia2">';
            }
            echo'<td class="tytul">'.$row[1].'</td>';
            echo'<td class="data">'.$row[3].'</td>';
            echo'<td class="plus"><a href="article_preview.php?article_id='.$row[0].'">+</a></td>';
            if($row[5] == $_SESSION['user_id'])
            {
                echo'<td class="plus"><a href="article_stanChange.php?article_id='.$row[0].'&from=1">+</a></td>';
                echo'<td class="plus"><a href="freerte/examples/edycja_articles.php?article_id='.$row[0].'">+</a></td>';
            echo'<td class="plus"><a href="article_deleteConfirm.php?article_id='.$row[0].'">+</a></td>';
            }
            else
            {
                echo'<td class="plus"><u>+</u></td>';
                echo'<td class="plus"><u>+</u></td>';
                echo'<td class="plus"><u>+</u></td>';                
            }
            echo '</tr>';
        }
        echo '</table>';
        echo '<br>';




	mysqli_close($conn);	
	echo'	</div>
		
	</div>
	<!-- end content -->';
	}
	public function WyswietlSidebar()
	{
	
        echo'<div id="sidebar_kokpit">';
            echo'<div id="log_box">';
            if(isset($_SESSION['zalogowany']))
            {
                echo 'Zalogowany: '.$_SESSION['user'].' <br><a href="log_out.php">Wyloguj</a> / <a href="index.php"> Strona główna</a>';
            }
            else                                
            {
                echo'<a href="login.php">Logowanie </a> / <a href="register.php">Rejestracja </a>';
            }
            echo'</div><div style="clear: both;"></div>'; //end of log_box
            echo'
		<div id="extra" class="boxed">
			<h2 class="title">Artykuły</h2>
			<div class="content">
				<ul class="list">
					<li class="first"><a href="kokpit_articlesList.php">Lista artykułów</a></li>
					<li><a href="kokpit_articlesUser.php">Moje artykuły</a></li>
                                        <li><a href="freerte/examples/edycja_articles.php?article_id=new">Dodaj artykuł</a></li>
				</ul>
			</div>
		</div>
		<div id="extra" class="boxed">
			<h2 class="title">Zakładki strony głównej</h2>
			<div class="content">
				<ul class="list">
					<li class="first"><a href="kokpit_pagesList.php">Lista Stron</a></li>';
					echo'<li><a href="freerte/examples/edycja_pages.php?page_id=new">Dodaj stronę</a></li>';
				echo'</ul>
			</div>
		</div>
                <div id="extra" class="boxed">
			<h2 class="title">Profil użytkownika</h2>
			<div class="content">
				<ul class="list">
					<li class="first"><a href="kokpit_userProfile.php">Wyświetl</a></li>
					<li><a href="kokpit_editProfile.php">Edytuj</a></li>
                                        <li><a href="kokpit_pswChange.php">Zmień hasło</a></li>
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
	<p id="links">Autor witryny: Wiktor Stącel, wiktor.stacel(at)hotmail.com. Wszelkie prawa zastrzeżone.</p>';
	
		echo'<div id="flash3"></div>
                               <script type="text/javascript">
                               // <![CDATA[
                               window.scrollBy(0, 200);
                               flash("flash3", "blue", 20000, "aqua", 50);

                               // ]]>
                               </script>
	
     </div>';
    }
     
    }

?>
