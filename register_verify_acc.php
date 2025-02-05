<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require ('strona_stage.php');

class verify_account extends Strona2
{
    
    public function WeryfikujKonto()
    {
        //logika
        if(!isset($_GET['email']) || !isset($_GET['token']))
        {
            header('location: register.php');
            exit();
        }
        else
        {
            require 'config_db.php';
            
            $email = htmlentities($_GET['email'], ENT_QUOTES, "UTF-8");
            $token = htmlentities($_GET['token'], ENT_QUOTES, "UTF-8");

            $result = $conn->query(
                    sprintf("SELECT * FROM users WHERE email='%s' AND token='%s' AND verifed=0",
                    $conn->real_escape_string($email),
                    $conn->real_escape_string($token)        
                            ));           
            if(!$result){echo "MySQL Error: ".mysqli_error($conn);}
            else
            {
                if(mysqli_num_rows($result) >0 )
                {
                    $result = $conn->query("UPDATE users SET token='', verifed=1 WHERE email='$email'");
                    if(!$result){echo "MySQL Error: ".mysqli_error($conn);}
                    else
                    {
                        echo 'Werefikacja poprawna, zaloguj się i uzupełnij dane konta w profilu użytkownika.'
                        . '<a href="login.php"> Strona logowania.</a>';
                    }
                }
                else
                {
                    header('location: register.php');
                    exit();            
                }
            }


            mysqli_close($conn);
        }
    }
    
    public function WyswietlPage()
    {
      echo '
        <div id="content" style="float:right;">
            <div style="margin-bottom: 20px;">';
            
            $this->WeryfikujKonto();
        
            echo'</div>
        </div>';
    }


}

$header_type = 2;
$show_content = true;
$show_sidebar = false; 
$show_motto = true;

$verify_account = new verify_account($header_type, $show_content, $show_sidebar, $show_motto);

$verify_account -> title = 'Weryfikacja e-mail';

$verify_account -> keywords = 'weryfikacja konta e-mail';

$verify_account -> description = 'weryfikacja konta';

$verify_account -> Wyswietl();