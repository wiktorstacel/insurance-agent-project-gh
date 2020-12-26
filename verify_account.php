<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require ('strona_stage.inc');

class verify_account extends Strona2
{
    public function WeryfikujKonto()
    {
        //logika
        if(!isset($_GET['email']) || !isset($_GET['token']))
        {
            header('location: rejestracja.php');
            exit();
        }
        else
        {
            require_once 'config_db.php';
            
            $email = htmlentities($_GET['email'], ENT_QUOTES, "UTF-8");
            $token = htmlentities($_GET['token'], ENT_QUOTES, "UTF-8");
            $email = $conn->real_escape_string($email);
            $token = $conn->real_escape_string($token);

            $result = $conn->query("SELECT * FROM users WHERE email='$email' AND token='$token' AND verifed=0");
            if(!$result){echo "MySQL Error: ".mysqli_error($conn);}
            else
            {
                if(mysqli_num_rows($result) >0 )
                {
                    $result = $conn->query("UPDATE users SET token='', verifed=1 WHERE email='$email'");
                    if(!$result){echo "MySQL Error: ".mysqli_error($conn);}
                    else
                    {
                        echo 'Werefikacja poprawna, '
                        . ' <a href="logowanie.php">strona logowania.</a></span>';
                    }
                }
                else
                {
                    header('location: rejestracja.php');
                    exit();            
                }
            }


            mysqli_close($conn);
        }
    }
    
    public function WyswietlPage()
    {
      echo '<div id="page">
        <div id="content" style="float:right;">
            <div style="margin-bottom: 20px;">';
            
            $this->WeryfikujKonto();
        
            echo'</div>
        </div>';
    }
    
    public function WyswietlSidebar()
    {
	echo'<div id="sidebar" style="float:left;">';

//<!-- write sidebar content here -->

	echo'</div>
	<!-- end sidebar -->
	<div style="clear: both;">&nbsp;</div>
     </div><!-- end page -->';
    }

}

$verify_account = new verify_account();

$verify_account -> title = 'Weryfikacja e-mail';

$verify_account -> keywords = 'weryfikacja konta e-mail';

$verify_account -> description = 'weryfikacja konta';

$verify_account -> Wyswietl();