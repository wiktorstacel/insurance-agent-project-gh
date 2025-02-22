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
    $errors = [];

    $login = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");
    $email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8");
    $haslo = htmlentities($_POST['haslo'], ENT_QUOTES, "UTF-8");
    $haslo2 = htmlentities($_POST['haslo2'], ENT_QUOTES, "UTF-8");
    $languages = htmlentities($_POST['languages'], ENT_QUOTES, "UTF-8");

    $regulamin = filter_var($_POST['regulamin'], FILTER_VALIDATE_BOOLEAN);
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);//zwraca string usuwając (np) polskie znaki
    $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);

    
    $errorEmpty = false;
    $errorLogin = false;
    $errorEmail = false;
    $errorHaslo = false;
    $errorHaslo2 = false;
    $errorGender = false;
    $errorRegulamin = false;
    $errorBot = false;

    
    if(empty($login) || empty($email) || empty($haslo) || empty($haslo2))//czy jest jakieś puste pole
    {
        $errorEmpty = true;
        echo '<span class="form-error">Wypełnij wszystkie pola!</span>';
        $errors['empty'] = "Wypełnij wszystkie pola!";
    }
    elseif(ctype_alnum($login) == false)//sprawdź odpowiednie znaki login
    {
        $errorLogin = true;
        echo '<span class="form-error">Login może składać się tylko z liter i cyfr (bez polskich znaków)!</span>';
        $errors['login'] = "Login może składać się tylko z liter i cyfr (bez polskich znaków)!";
    }
    elseif(strlen($login) < 3 || strlen($login) > 20)//sprawdz długość login
    {
        $errorLogin = true;
        echo '<span class="form-error">Login musi posiadać od 3 do 20 znaków!</span>';
        $errors['login'] .= " Login musi posiadać od 3 do 20 znaków!";
    }
    elseif ((!filter_var($emailB, FILTER_VALIDATE_EMAIL)) || $email != $emailB) //sprawdz poprawnosc email
    {
        $errorEmail = true;
        echo '<span class="form-error">Wprowadź poprawny e-mail!</span>';   
        $errors['email'] = "Wprowadź poprawny e-mail!";
    }
    elseif((strlen($haslo) < 8) || (strlen($haslo) > 20))//sprawdz poprawność hasla
    {
        $errorHaslo = true;
        echo '<span class="form-error">Hasło musi posiadać od 8 do 20 znaków!</span>';
        $errors['haslo'] = "Hasło musi posiadać od 8 do 20 znaków!";
    }
    elseif (!preg_match("#[0-9]+#", $haslo)) 
    {
        $errorHaslo = true;
        echo '<span class="form-error">Hasło musi posiadać co najmniej jedną cyfrę!</span>';
        $errors['haslo'] .= " Hasło musi posiadać od 8 do 20 znaków!";
    }
    elseif (!preg_match("#[a-zA-Z]+#", $haslo)) 
    {
        $errorHaslo = true;
        echo '<span class="form-error">Hasło musi posiadać co najmniej jedną literę!</span>';
        $errors['haslo'] .= " Hasło musi posiadać co najmniej jedną literę!";
    }
    elseif($haslo != $haslo2)//sprawdz zgodność 2 haseł
    {
        $errorHaslo2 = true;
        echo '<span class="form-error">Podane hasła nie są identyczne!</span>';
        $errors['haslo2'] = "Podane hasła nie są identyczne!";
    }
    elseif(!isset($_POST['gender']))//sprawdz czy zaznaczono płeć
    {
        $errorGender = true;
        echo '<span class="form-error">Zaznacz pole płeć!</span>';
        $errors['gender'] = "Zaznacz pole płeć!";
    }
    elseif($regulamin != 1)//czy zaakceptowano regulamin
    {
        $errorRegulamin = true;
        echo '<span class="form-error">Potwierdź akceptację regulaminu!</span>';
        $errors['regulamin'] = "Potwierdź akceptację regulaminu!";
    }   
    elseif(empty($_POST['captchaResponse']))
    {
        //reCapcha
        //$_POST['captchaResponse'] zamiast standardowego $_POST['g-recaptcha-response'], bo odbieram te dane
        //w js(jquery) i przesyłam do tego pliku pod inną nazwą
        $errorBot = true;
        echo '<span class="form-error">Potwierdź, że nie jesteś robotem!</span>';
        $errors['bot'] = "Potwierdź, że nie jesteś robotem!";
    }
    else
    {
        require_once 'config_reCaptcha.php';
        $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['captchaResponse']);
        $response = json_decode($check);
        //printf($response->success);
        if(($response->success))
        {
            $errorBot = true;
            echo '<span class="form-error">Błąd weryfikacji reCaptcha!</span>';
            $errors['bot'] = "Błąd weryfikacji reCaptcha!";
        }
    }
    
    
    //dane wejsciowe zwalidowane, sprawdzamy dalsze warunki wykorzystując MySQL
    if($errorEmpty == false && $errorLogin == false && $errorEmail == false && $errorHaslo == false && $errorHaslo2 == false && $errorGender == false && $errorRegulamin == false && $errorBot == false)
    {       
        mysqli_report(MYSQLI_REPORT_STRICT);        
        try
        {
            require_once 'config_db.php';
            if(mysqli_connect_errno() != 0) throw new Exception('Connection failed: ' . mysqli_connect_error());

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
                    $mail->CharSet = "UTF-8";
                    $mail->setFrom('info@ubezpieczenia-odszkodowania.pl');
                    $mail->FromName="ubezpieczenia-odszkodowania";
                    $mail->addAddress($email);
                    $mail->Subject = "Weryfikacja adresu e-mail - serwis Ubezpieczenia i Odszkodowania";
                    $mail->Body = "
                        Kliknij poniższy link w celu weryfikacji adresu e-mail:<br><br>

                        <a href='https://ubezpieczenia-odszkodowania.pl/register_verify_acc.php?email=$email&token=$token'>Weryfikacja</a>
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
            //echo '<br>Informacja deweloperska: '.$ex;
        }
    }

    
}
else
{
    echo 'Błąd przetwarzania danych!';
}
?>

<script>
    $("#rej_login, #rej_email, #rej_haslo, #rej_haslo2, #rej_male, #rej_female, #rej_regulamin").removeClass("input-error");
    grecaptcha.reset(); //kasowanie reCapcha
    
    var errorEmpty = "<?php echo $errorEmpty; ?>";
    var errorLogin = "<?php echo $errorLogin; ?>";
    var errorEmail = "<?php echo $errorEmail; ?>";
    var errorHaslo = "<?php echo $errorHaslo; ?>";
    var errorHaslo2 = "<?php echo $errorHaslo2; ?>";
    var errorGender = "<?php echo $errorGender; ?>";
    var errorRegulamin = "<?php echo $errorRegulamin; ?>";
    var errorBot = "<?php echo $errorBot; ?>";
    
    if(errorEmpty == true){
        $("#rej_login, #rej_email, #rej_haslo, #rej_haslo2").addClass("input-error");
    }
    if(errorLogin == true){
        $("#rej_login").addClass("input-error");
    }
    if(errorEmail == true){
        $("#rej_email").addClass("input-error");
    }
    if(errorHaslo == true){
        $("#rej_haslo").addClass("input-error");
    }
    if(errorHaslo2 == true){
        $("#rej_haslo2").addClass("input-error");
    }
    if(errorGender == true){
        $("#rej_male, #rej_female").addClass("input-error");
    }
    if(errorRegulamin == true){
        $("#rej_regulamin").addClass("input-error");
    }
    if(errorEmpty == false && errorLogin == false && errorEmail == false && errorHaslo == false && errorHaslo2 == false && errorGender == false && errorRegulamin == false && errorBot == false)
    {
        $("#rej_login, #rej_email, #rej_haslo, #rej_haslo2, #rej_male, #rej_female").val("");
        $("#language1, #language2, #language3, #language4, \n\
#language5, #language6, #language7, #rej_male_inp, #rej_female_inp, #rej_regulamin").prop('checked', false);
    }
    
</script>