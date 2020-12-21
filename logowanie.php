<?php

require ('strona_stage.inc');

class logowanie extends Strona2
{
   
    public function ObsluzSesje()
    {
        session_start();
        if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == TRUE))
        {
            header('location: kokpit_stage.php');
            exit();
        }
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
                                            if(isset($_SESSION['blad'])){echo $_SESSION['blad'];}
                                   echo'</p>
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

$logowanie = new logowanie();

$logowanie -> title = 'Logowanie';

$logowanie -> keywords = 'ubezpieczenia, komunikacyjne, rzeszów, podkarpackie';

$logowanie -> description = 'Logowanie do strony';

$logowanie -> Wyswietl();

?>
