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
    $user_id = htmlentities($_POST['user_id'], ENT_QUOTES, "UTF-8");
    $inquiry = htmlentities($_POST['inquiry'], ENT_QUOTES, "UTF-8");
    $name = htmlentities($_POST['name'], ENT_QUOTES, "UTF-8");
    $email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8");
    $telefon = htmlentities($_POST['telefon'], ENT_QUOTES, "UTF-8");

    $regulamin = filter_var($_POST['regulamin'], FILTER_VALIDATE_BOOLEAN);
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);//zwraca string usuwając (np) polskie znaki
    
    $errorEmpty = false;
    $errorUser_id = false;
    $errorInquiry = false;
    $errorName = false;
    $errorEmail = false;
    $errorTelefon = false;
    $errorRegulamin = false;
    

    
    if(empty($inquiry) || empty($name) || empty($email))//czy jest jakieś puste pole
    {
        echo '<span class="form-error-contact">Wypełnij wymagane pola.</span>';
        $errorEmpty = true;
    }
    elseif(ctype_alnum($login) == false)//sprawdź odpowiednie znaki login
    {
        $errorLogin = true;
        echo '<span class="form-error">Login może składać się tylko z liter i cyfr (bez polskich znaków)!</span>';
    }
    elseif(strlen($login) < 3 || strlen($login) > 20)//sprawdz długość login
    {
        $errorLogin = true;
        echo '<span class="form-error">Login musi posiadać od 3 do 20 znaków!</span>';
    }
    elseif ((!filter_var($emailB, FILTER_VALIDATE_EMAIL)) || $email != $emailB) //sprawdz poprawnosc email
    {
        $errorEmail = true;
        echo '<span class="form-error">Wprowadź poprawny e-mail!</span>';   
    }
    elseif((strlen($haslo) < 8) || (strlen($haslo) > 20))//sprawdz poprawność hasla
    {
        $errorHaslo = true;
        echo '<span class="form-error">Hasło musi posiadać od 8 do 20 znaków!</span>';
    }
    elseif (!preg_match("#[0-9]+#", $haslo)) 
    {
        $errorHaslo = true;
        echo '<span class="form-error">Hasło musi posiadać co najmniej jedną cyfrę!</span>';
    }
    elseif (!preg_match("#[a-zA-Z]+#", $haslo)) 
    {
        $errorHaslo = true;
        echo '<span class="form-error">Hasło musi posiadać co najmniej jedną literę!</span>';
    }
    elseif($haslo != $haslo2)//sprawdz zgodność 2 haseł
    {
        $errorHaslo2 = true;
        echo '<span class="form-error">Podane hasła nie są identyczne!</span>';
    }
    elseif(!isset($_POST['gender']))//sprawdz czy zaznaczono płeć
    {
        $errorGender = true;
        echo '<span class="form-error">Zaznacz pole płeć!</span>';
    }
    elseif($regulamin != 1)//czy zaakceptowano regulamin
    {
        $errorRegulamin = true;
        echo '<span class="form-error">Potwierdź akceptację regulaminu!</span>';
    }
    //reCapcha do wstawienia jak już będzie wrzucane na serwer, v3 sprawdzającą content strony np artykuły
    else
    {       
        //echo '<span class="form-success">Jeszcze SQL check... </span>';
    }
    
    
    //dane wejsciowe zwalidowane, sprawdzamy dalsze warunki wykorzystując MySQL
    if($errorEmpty == false && $errorLogin == false && $errorEmail == false && $errorHaslo == false && $errorHaslo2 == false && $errorGender == false && $errorRegulamin == false)
    {       
        mysqli_report(MYSQLI_REPORT_STRICT);        
        try
        {
            require_once 'config_db.php';
            if(mysqli_connect_errno($conn) != 0) throw new Exception(mysqli_connect_errno());

            //sprawdz czy nie ma już takiego loginu
            $result = mysqli_query($conn, 
            sprintf("SELECT * FROM users WHERE login='%s'",
            mysqli_real_escape_string($conn, $login)));
            if(!$result) throw new Exception(mysqli_error($conn));
            $ile_takich_login = mysqli_num_rows($result);
            if($ile_takich_login > 0)
            {
                $errorLogin = true;
                echo '<span class="form-error">Istnieje już konto z takim loginem!</span>';
            }

            //czy email już istnieje
            $result = mysqli_query($conn, 
            sprintf("SELECT * FROM users WHERE email='%s'",
            mysqli_real_escape_string($conn, $email)));
            if(!$result) throw new Exception(mysqli_error($conn));
            $ile_takich_maili = mysqli_num_rows($result);
            if($ile_takich_maili > 0)
            {                   
                if($errorLogin != true)
                {
                    $errorEmail = true;
                    echo '<span class="form-error">Istnieje już konto z takim adresem e-mail!</span>';
                }
            }

            if($errorLogin == false && $errorEmail == false)
            {
                    //Tworzenie tokena do weryfikacji e-maila
                    $token = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789!/)(*';
                    $token = str_shuffle($token);
                    $token = substr($token, 0, 20);

                    //Wysłanie email do użytkownika w celu weryfikacji
                    include_once "PHPMailer/PHPMailer.php";
                    include_once "PHPMailer/SMTP.php";
                    include_once "PHPMailer/Exception.php";

                    require_once 'config_smtp.php';
                    //Email Settings
                    $mail->isHTML(true);
                    $mail->setFrom('confirm@ubezpieczenia-odszkodowania.com');
                    $mail->addAddress($email);
                    $mail->Subject = "Weryfikacja adresu e-mail - portal ubezpieczenia i odszkodowania";
                    $mail->Body = "
                        Kliknij link w celu weryfikacji adresu e-mail:<br><br>

                        <a href='http://manager.test/register_verify_acc.php?email=$email&token=$token'>Weryfikacja</a>
                    ";
                    if($mail->send())
                    {
                        //wszystkie testy zaliczone, dodajemy usera do bazy - dopiero po poprawnym wysłaniu email
                        $gender = htmlentities($_POST['gender'], ENT_QUOTES, "UTF-8");//tu jest pewność, że ustawiona zmienna POST

                        $result = mysqli_query($conn, 
                        sprintf("INSERT INTO users (`user_id`, `login`, `pass`, `email`, `gender`, `languages`, `token`) "
                                . "VALUES (DEFAULT, '%s', '%s', '%s', '%s', '%s', '%s')",
                        mysqli_real_escape_string($conn, $login),
                        mysqli_real_escape_string($conn, $haslo_hash),
                        mysqli_real_escape_string($conn, $email),
                        mysqli_real_escape_string($conn, $gender),
                        mysqli_real_escape_string($conn, $languages),
                        mysqli_real_escape_string($conn, $token)
                                ));

                        if($result){echo '<span class="form-success">Nowe konto utworzone. '
                        . 'Sprawdź skrzynkę pocztową i potwierdź rejestrację.<br>'
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


            mysqli_close($conn);
            
        } 
        catch (Exception $ex) 
        {
            echo '<span class="form-error">Błąd serwera - prosimy o rejestrację w innym terminie.</span>';
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
    $("#kont_inquiry, #kont_name, #kont_mail, #kont_telefon, #kont_regulamin").removeClass("input-error");
    
    var errorEmpty = "<?php echo $errorEmpty; ?>";
    var errorUser_id = "<?php echo $errorUser_id; ?>";
    var errorInquiry = "<?php echo $errorInquiry; ?>";
    var errorName = "<?php echo $errorName; ?>";      
    var errorEmail = "<?php echo $errorEmail; ?>";
    var errorTelefon = "<?php echo $errorTelefon; ?>";
    var errorRegulamin = "<?php echo $errorRegulamin; ?>";
    
    if(errorEmpty == true){
        $("#kont_inquiry, #kont_name, #kont_email").addClass("input-error");
    }
    if(errorInquiry == true){
        $("#kont_inquiry").addClass("input-error");
    }
    if(errorName == true){
        $("#kont_name").addClass("input-error");
    }
    if(errorEmail == true){
        $("#kont_mail").addClass("input-error");
    }
    if(errorTelefon == true){
        $("#kont_telefon").addClass("input-error");
    }
    if(errorRegulamin == true){
        $("#kont_regulamin").addClass("input-error");
    }
    if(errorEmpty == false && errorInquiry == false && errorName == false && errorEmail == false && errorTelefon == false && errorRegulamin == false)
    {
        $("#kont_inquiry, #kont_name, #kont_mail, #kont_telefon").val("");
        $("#rej_regulamin").prop('checked', false);
    }
    
</script>