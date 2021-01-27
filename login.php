<?php

require ('strona_stage.inc');

class login extends Strona2
{
   
    public function ObsluzSesje()
    {
        session_start();
        if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == TRUE))
        {
            header('location: kokpit_userProfile.php');
            exit();
        }
    }
    
    public function WyswietlHeader()
    {
      echo '<div id="header_parent">';
      echo '<div id="header">
	<div id="logo">
		<h1><a href="index.php">Ubezpieczenia i Odszkodowania</a></h1>
		<h2><a href="index.php">Rzeszów, Podkarpackie</a></h2>
	</div>
	<div id="menu">
		<ul>';
                    print("<li class=\"noactive\"><a style=\"color: white;\" href=\"index.php\">Powrót na stronę główną</a></li>");
     echo'	</ul>
	</div>
     </div>';
     echo '</div>';
    }
    
    public function WyswietlPage()
    {
      echo '<div id="page">
        <div id="content" style="float:right;">
            <div style="margin-bottom: 20px;">';
            
                //<!-- write content here -->
        
            echo'</div>
        </div>';
    }
    
    public function WyswietlSidebar()
    {
	echo'<div id="sidebar" style="float:left;">
		<div id="search" class="boxed">
			<h2 class="title">Logowanie</h2>
			<div class="content">
				<form id="log_form" method="POST" action="log_in.php">
					<fieldset>
                                        <label for="log_login">Login: </label>
					<input id="log_login" type="text" name="log_login" value="" />
                                        <br /><br />
                                        <label for="log_haslo">Hasło: </label>
                                        <input id="log_haslo" type="password" name="log_haslo" value="" />
                                        <br /><br />
					<input id="log_submit" type="submit" value="Zaloguj" />
                                        <p id="log_message">';
                                            if(isset($_SESSION['blad'])){echo $_SESSION['blad'];unset($_SESSION['blad']);}
                                   echo'</p>
                                        <br /><br /><br />
                                        <label><a href="reset_psw_rqst.php">Nie pamiętam hasła.</a></label>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
	<!-- end sidebar -->
	<div style="clear: both;">&nbsp;</div>
     </div><!-- end page -->';
    }

}

$login = new login();

$login -> title = 'Logowanie';

$login -> keywords = 'ubezpieczenia, komunikacyjne, rzeszów, podkarpackie';

$login -> description = 'Logowanie do strony';

$login -> Wyswietl();

?>
