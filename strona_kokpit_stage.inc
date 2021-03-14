<?php


class kokpit_stage
{
    protected $header_type;
    protected $show_content;
    protected $show_sidebar;
    public $stopka = 'Autor witryny: Wiktor Stącel, wiktor.stacel@hotmail.com. &copy;2021 Wszelkie prawa zastrzeżone.';
    
    public function __construct($header_type, $show_content, $show_sidebar) {
        $this->header_type = $header_type;
        $this->show_content = $show_content;
        $this->show_sidebar = $show_sidebar;
    }

    public function Wyswietl()
    {
      $this -> ObsluzSesje();
      //echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">';
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
        echo '<div id="page_kokpit">';
        if($this -> show_content){$this -> WyswietlPage();}
        if($this -> show_sidebar)$this -> WyswietlSidebar();
        echo '<div style="clear: both;">&nbsp;</div></div>';
        $this -> WyswietlFooter();
        //$this -> WyswietlMenuPoziom($this->przyciski_poz);

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
        else
        {
            //log out after 30 minuts of inactivity
            if(time() - $_SESSION['timestamp'] > 1500) //subtract new timestamp from the old one
            { 
                //echo"<script>alert('Wylogowano z powodu 30 minut braku aktywności!');</script>";
                //unset($_SESSION['username'], $_SESSION['password'], $_SESSION['timestamp']);$_SESSION['logged_in'] = false;
                header("Location: log_out.php"); //redirect to index.php
                exit;
            } 
            else 
            {
                $_SESSION['timestamp'] = time(); //set new timestamp
            }
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
      echo '<link rel="icon" type="image/png" sizes="16x16" href="/css/images/favicon.png">';
      echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">';
    }

    public function WyswietlSkrypty()
    {
        echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
        echo '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>';
        echo '<script language="JavaScript" type="text/javascript" src="js/js_agent.js"></script>';
        echo '<script language="JavaScript" type="text/javascript" src="js/jquery_agent.js"></script>';
    }

   public function WyswietlHeader()
    {
      echo '<header id="header_parent">';//<div id="header_parent">';
      echo '<div id="header">
	<div id="logo">
		<h1><a href="#">Zarządzanie treścią witryny</a></h1>
	</div>';
      
        if($this->header_type === 2)
        {
            echo '<div id="menu">
                    <ul>
                            <li class="active"><a href="index.php">Powrót na strona główną</a></li>
                    </ul>
            </div>';
        }
        elseif(($this->header_type === 3))
        {
            echo '<div id="menu">
                    <ul>
                            <li class="active"><a href="../../kokpit_articlesUser.php">Powrót do kokpitu</a></li>
                    </ul>
            </div>';
        }
        
     echo '</div>';
     echo '</header>';//</div>';
    }

    public function WyswietlPage()
    {

    echo '
	<div id="content_kokpit">
		<div style="margin-bottom: 20px;">';
		
        echo '<br>';
        echo "<table class='lista_art'>";
        echo "<tr class='listwa'>";
        echo'<td class="tytul">Tytuł artykułu</td>';
        echo'<td class="data">Data dodania</td>';
        echo '<td>W</td>';
        echo '<td>Podgląd</td>';
        echo'<td class="stan">Stan</td>';
        echo '<td>Edycja</td>';
        echo '<td>Usuń</td>';
        echo '</tr>';
        require 'config_db.php';
        if(!isset($_GET['articlesSum']))
        {
            $result = mysqli_query($conn, "SELECT * FROM articles ORDER BY date DESC LIMIT 10 OFFSET 0");
            $row_number = mysqli_num_rows($result);
        }
        else
        {
            $articlesSum = htmlentities($_GET['articlesSum'], ENT_QUOTES, "UTF-8");
            $result = mysqli_query($conn, 
                    sprintf("SELECT * FROM articles ORDER BY date DESC LIMIT 10 OFFSET %d",
                            mysqli_real_escape_string($conn, $articlesSum)
                            ));
        }
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
            echo'<td class="plus">'.$row[7].'</td>';
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

        if(!isset($_GET['articlesSum']))
        {
            
            $result = mysqli_query($conn, "SELECT * FROM articles ORDER BY date DESC LIMIT 1000000 OFFSET 0");
            $row_number = mysqli_num_rows($result);
            if($row_number > 10)
            {
                echo '<a href="kokpit_articlesList.php?articlesSum=10"><button style="float: right;" id="button_more_articles" class="btn btn-light">Dalej >></button></a>';
            }
        }
        else
        {
            $result_pom = mysqli_query($conn, 
            sprintf("SELECT * FROM articles ORDER BY date LIMIT 1000000 OFFSET %d",
                mysqli_real_escape_string($conn, $articlesSum)
                ));
            if($result_pom != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
            $row_number = mysqli_num_rows($result_pom);
            if($row_number > $articlesSum)
            {
                $articlesSum_10more = $articlesSum+10;
                $articlesSum_10less = $articlesSum-10;
                echo '<a href="kokpit_articlesList.php?articlesSum='.$articlesSum_10more.'"><button style="float: right;" id="button_more_articles" class="btn btn-light">Dalej >></button></a>';
                if($articlesSum >= 10)
                echo '<a href="kokpit_articlesList.php?articlesSum='.$articlesSum_10less.'"><button style="float: right; margin-right:6px;" id="button_more_articles" class="btn btn-light"><< Wstecz</button></a>';
            }
            else
            {
                $articlesSum_10less = $articlesSum-10;
                echo '<a href="kokpit_articlesList.php?articlesSum='.$articlesSum_10less.'"><button style="float: right; margin-right:6px;" id="button_more_articles" class="btn btn-light"><< Wstecz</button></a>';
            }
        }




	mysqli_close($conn);	
	echo'	</div>
		
	</div>
	<!-- end content_kokpit -->';
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
                                        <li><a href="freerte/examples/edycja_articles.php?article_id=new">Dodaj artykuł</a></li>';
                                        require 'config_db.php';
                                        $result = mysqli_query($conn, 
                                            sprintf("SELECT COUNT( * ) FROM inquiries WHERE stan=1 AND `user_id`='%d' GROUP BY user_id",
                                                mysqli_real_escape_string($conn, $_SESSION['user_id'])
                                                    ));
                                        $row = mysqli_fetch_array($result, MYSQLI_NUM);
                                        if($row[0] < 1)
                                        {
                                            echo'<li class="first"><a href="kokpit_inquiriesList.php">Zapytania</a></li>';
                                        }
                                        else
                                        {
                                            echo'<li class="first"><a href="kokpit_inquiriesList.php"><b>Zapytania('.$row[0].')</b></a></li>';
                                        }
				echo'</ul>
			</div>
		</div>
		<div id="extra" class="boxed">
			<h2 class="title">Zakładki strony głównej</h2>
			<div class="content">
				<ul class="list">
					<li class="first"><a href="kokpit_pagesList.php">Lista Stron</a></li>';
					//echo'<li><a href="freerte/examples/edycja_pages.php?page_id=new">Dodaj stronę</a></li>';
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
	<!-- end sidebar_kokpit -->';
    }
     
     public function WyswietlFooter()
    {
        echo '<footer id="footer">';//<div id="footer">
	//echo'<p id="legal">&copy;2015 Center Stage. All Rights Reserved. Designed by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a></p>';
	echo '<p id="links">'.$this->stopka.'</p>';
     
		echo'<div id="flash3"></div>
                               <script type="text/javascript">
                               // <![CDATA[
                               window.scrollBy(0, 190);
                               flash("flash3", "blue", 20000, "aqua", 50);

                               // ]]>
                               </script>
	
        </footer>';//</div>';
    }
     
    }

?>
