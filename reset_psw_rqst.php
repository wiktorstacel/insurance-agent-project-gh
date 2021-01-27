<?php

require ('strona_stage.inc');

class reset_psw_rqst extends Strona2
{   
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
                <div id="rejestra_field">
                    <h1 class="title">Odzyskiwanie hasła</h1>
                    <div id="res_psw_div">
                    <form id="res_psw_form" method="POST" action="reset_psw.php">
                            <fieldset>
                            <label for="res_psw_email">E-mail: </label>
                            <input id="res_psw_email" type="text" name="res_psw_email" value="" />
                            <br /><br />                        
                            <input id="res_psw_submit" type="submit" value="Wyślij" />
                            <br />
                            <p id="res_psw_message">Na podany adres zostanie wysłany link, który należy kliknąć, 
                            aby przejść do strony tworzenia nowego hasła.</p>
                            </fieldset>
                    </form>
                    </div>
                </div>
        ';
    }
    
    public function WyswietlSidebar()
    {
	echo'
            </div><!-- end page -->';
    }

}

$reset_psw_rqst = new reset_psw_rqst();

$reset_psw_rqst -> title = 'Odzyskiwanie dostępu do konta';

$reset_psw_rqst -> keywords = 'ubezpieczenia';

$reset_psw_rqst -> description = 'Odzyskaj hasło';

$reset_psw_rqst -> Wyswietl();

?>
