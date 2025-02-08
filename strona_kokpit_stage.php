<?php


abstract class kokpit_stage
{
    public $title = 'Kokpit';
    public $keywords = 'kokpit';
    public $description = 'kokpit';
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

    protected function render($view, $data = [])
    {
        extract($data);//extract($data) konwertuje tablicę ['article' => $article] na zmienną $article, która jest dostępna w pliku article.php (widoku).
        include $view;
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
        echo '<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>';
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

    abstract function WyswietlPage();

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
