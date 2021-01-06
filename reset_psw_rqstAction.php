<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST['submit']))
{
    $email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8");
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);//zwraca string usuwając (np) polskie znaki
    
    $errorEmpty = false;
    $errorEmail = false;    
   
    if(empty($email))//czy pole nie jest puste
    {
        echo '<span class="form-error">Wypełnij pole!</span>';
        $errorEmpty = true;
    }
    elseif ((!filter_var($emailB, FILTER_VALIDATE_EMAIL)) || $email != $emailB) //sprawdz poprawnosc email
    {
        $errorEmail = true;
        echo '<span class="form-error">Wprowadź poprawny e-mail!</span>';   
    }
    else
    {       
        //echo '<span class="form-success">Jeszcze SQL check... </span>';
    }
    
    
    //dane wejsciowe zwalidowane, sprawdzamy dalsze warunki wykorzystując MySQL
    if($errorEmpty == false && $errorEmail == false)
    {       
        mysqli_report(MYSQLI_REPORT_STRICT);        
        try
        {
            require_once 'config_db.php';
            if(mysqli_connect_errno($conn) != 0) throw new Exception(mysqli_connect_errno());

            //czy taki email istnieje
            $result = mysqli_query($conn, 
            sprintf("SELECT * FROM users WHERE email='%s'",
            mysqli_real_escape_string($conn, $email)));
            if(!$result) throw new Exception(mysqli_error($conn));
            $ile_takich_maili = mysqli_num_rows($result);
            $row = mysqli_fetch_assoc($result);
            if($ile_takich_maili > 0 && $row['verifed'] == 1) //tylko zweryfikowane akceptowane
            {                                   
                //Tworzenie selektora i tokena
                $selector = bin2hex(random_bytes(8));
                $token = random_bytes(32);
                $hexToken = bin2hex($token);
//echo "selector: ".$selector." i nakedToken: ".$token;

                $hashedToken = password_hash($token, PASSWORD_DEFAULT);
//echo "2selector: ".$selector." i hexNakedToken: ".$hexToken."<br> i hashedNakedToken: ".$hashedToken." i HexHashedToken: ".bin2hex($hashedToken);

                //Data wygaśnięcia 
                $expires = date("U") + 1800;

                //Usunięcie wcześniejszych wniosków użytkownika o zmianę hasła
                $result = mysqli_query($conn, 
                    sprintf("DELETE FROM pswReset WHERE pswResetEmail='%s'",
                    mysqli_real_escape_string($conn, $email)));
                if(!$result) throw new Exception(mysqli_error($conn));

                //Wysłanie email do użytkownika w celu wysłaniu linku
                include_once "PHPMailer/PHPMailer.php";
                include_once "PHPMailer/SMTP.php";
                include_once "PHPMailer/Exception.php";

                require_once 'config_smtp.php';
                //Email Settings
                $mail->isHTML(true);
                $mail->setFrom('confirm@ubezpieczenia-stawik964.com');
                $mail->addAddress($email);
                $mail->Subject = "Odzyskiwanie konta - serwis Ubezpieczenia i Odszkodowania";
                $mail->Body = "
                    Kliknij link w celu utworzenia nowego hasla:<br><br>

                    <a href='http://manager.test/reset_psw_new.php?selector=$selector&validator=$hexToken'>Link</a>
                ";
                if($mail->send())
                {
                    $result = mysqli_query($conn, 
                    sprintf("INSERT INTO pswReset (`pswResetId`, `pswResetEmail`, `pswResetSelector`, `pswResetToken`, `pswResetExpires`) "
                            . "VALUES (DEFAULT, '%s', '%s', '%s', '%s')",
                    mysqli_real_escape_string($conn, $email),
                    mysqli_real_escape_string($conn, $selector),
                    mysqli_real_escape_string($conn, $hashedToken),
                    mysqli_real_escape_string($conn, $expires)
                            ));

                    if($result){echo '<span class="form-success">Wiadomość wysłana. '
                    . 'Sprawdź skrzynkę pocztową i utwórz nowe hasło.<br>'
                            . '<a href="login.php">Logowanie</a></span>';}
                    else {throw new Exception(mysqli_error($conn));}
                }
                else
                {
                    $errorEmail = true;
                    echo '<span class="form-error">Błąd serwera - wysłania e-mail, spróbuj ponownie.</span>';
                    throw new Exception($mail->ErrorInfo);
                }


            }
            elseif($ile_takich_maili > 0 && $row['verifed'] == 0)
            {
                $errorEmail = true;
                echo '<span class="form-error">Konto jeszcze nie zweryfikowane! '
                . 'Sprawdź skrzynkę w celu poszukania wiadomości z aktywacją konta lub '
                        . 'skontakuj się z administratorem.</span>';                    
            }
            else
            {
                $errorEmail = true;
                echo '<span class="form-error">Nie ma konta z takim adresem e-mail!</span>';                           
            }
            mysqli_close($conn);
            
        } 
        catch (Exception $ex) 
        {
            echo '<span class="form-error">Błąd serwera - prosimy o powrót w innym terminie.</span>';
            echo '<br>Informacja deweloperska: '.$ex;
        }
    }
  
}
else
{
    echo 'Błąd przetwarzania danych!';
}
?>

<script>
    $("#res_psw_email").removeClass("input-error");
    
    var errorEmpty = "<?php echo $errorEmpty; ?>";
    var errorEmail = "<?php echo $errorEmail; ?>";
    
    if(errorEmpty == true){
        $("#res_psw_email").addClass("input-error");
    }
    if(errorEmail == true){
        $("#res_psw_email").addClass("input-error");
    }
    if(errorEmpty == false && errorEmail == false)
    {
        $("#res_psw_email").val("");
        $("#res_psw_email, #res_psw_submit").prop( "disabled", true );
    }
</script>