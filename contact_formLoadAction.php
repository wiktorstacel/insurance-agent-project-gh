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
    $errorBot = false;
   

    
    if(empty($inquiry) || empty($name) || empty($email))//czy jest jakieś puste pole
    {
        echo '<span class="form-error-contact">Wypełnij wymagane pola.</span>';
        $errorEmpty = true;
    }
    elseif((strlen($inquiry) < 20) || (strlen($inquiry) > 2000))//sprawdz poprawność hasla
    {
        $errorInquiry = true;
        echo '<span class="form-error-contact">Wiadomość ma niedopowiednią ilość znaków (min. 20, maks. 2000)</span>';
    }
    elseif(preg_match('/[^?!@%.,;ĄąĆćĘęŁłŃńÓóŚśŻżŹźa-zA-Z\s\d]/', $inquiry))//sprawdź odpowiednie znaki surname
    {
        $errorInquiry = true;
        echo '<span class="form-error-contact">Treść wiadomości może składać się tylko z liter(w tym polskich) oraz spacji i znaków ,.;?!%@</span>';            
    }
    elseif(strlen($name) < 3 || strlen($name) > 20)//sprawdz długość login
    {
        $errorName = true;
        echo '<span class="form-error-contact">Imię powinno posiadać od 3 do 20 znaków.</span>';
    }
    elseif(!preg_match("/^(ą|ę| |ź|ć|ń|ó|ś|ż|ł|Ą|Ę|Ź|Ć|Ń|Ó|Ś|Ż|[a-z]|[A-Z]){0,20}$/", $name))//sprawdź odpowiednie znaki surname
    {
        $errorName = true;
        echo '<span class="form-error-contact">Pole "Imię" może składać się tylko z liter(w tym polskich) oraz spacji, 0-20 znaków!</span>';            
    }
    elseif ((!filter_var($emailB, FILTER_VALIDATE_EMAIL)) || $email != $emailB) //sprawdz poprawnosc email
    {
        $errorEmail = true;
        echo '<span class="form-error-contact">Wprowadź poprawny e-mail.</span>';   
    }
    elseif(!preg_match("/^(\-|\+|\)|\(|\ |[0-9]){0,20}$/", $telefon))//sprawdź odpowiednie znaki surname
    {
        $errorTelefon = true;
        echo '<span class="form-error-contact">Pole "Telefon" może składać się tylko z cyfr i znaków +-() 0-20 znaków.</span>';            
    }
    elseif($regulamin != 1)//czy zaakceptowano regulamin
    {
        $errorRegulamin = true;
        echo '<span class="form-error-contact">Potwierdź akceptację regulaminu.</span>';
    }
    elseif(empty($_POST['captchaResponse']))
    {
        //reCapcha
        //$_POST['captchaResponse'] zamiast standardowego $_POST['g-recaptcha-response'], bo odbieram te dane
        //w js(jquery) i przesyłam do tego pliku pod inną nazwą
        $errorBot = true;
        echo '<span class="form-error-contact">Potwierdź, że nie jesteś robotem!</span>';
    }
    else
    {
        require_once 'config_reCaptcha.php';
        $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['captchaResponse']);
        $response = json_decode($check);
        //printf($response->success);
        if(!($response->success))
        {
            $errorBot = true;
            echo '<span class="form-error-contact">Błąd weryfikacji reCaptcha!</span>';
        }
    }
        
    //dane wejsciowe zwalidowane
    if($errorEmpty == false && $errorInquiry == false && $errorName == false && $errorEmail == false && $errorTelefon == false &&  $errorRegulamin == false && $errorBot == false)
    {       
        mysqli_report(MYSQLI_REPORT_STRICT);        
        try
        {
            require_once 'config_db.php';
            if(mysqli_connect_errno($conn) != 0) throw new Exception(mysqli_connect_errno());

            //sprawdz czy nie ma już takiego loginu
            $result = mysqli_query($conn, 
            sprintf("SELECT * FROM users WHERE user_id='%d'",
            mysqli_real_escape_string($conn, $user_id)));
            if(!$result) throw new Exception(mysqli_error($conn));
            $ile_takich_userow = mysqli_num_rows($result);
            if($ile_takich_userow < 1)
            {
                $errorUser_id = true;
                echo '<span class="form-error-contact">Błąd wysłania wiadomości do odbiorcy. Spróbuj ponownie lub napisz na adres e-mail administratora z prośbą o przekazanie do wybranego doradcy.</span>';
            }
            $row = mysqli_fetch_assoc($result);
            $user_email = $row['email'];
            $user_surname = $row['surname'];
            
            //zapisanie kontaktu do bazy - na wszelki wypadek teraz jakby nie udało się wysłać maili, to będzie
            //w bazie do odtworzenia.
            $result = mysqli_query($conn, 
            sprintf("INSERT INTO inquiries (`inquiry_id`, `inquiry`, `name`, `email`, `telefon`, `date`, `stan`, `user_id`) "
                    . "VALUES (DEFAULT, '%s', '%s', '%s', '%s', NOW(), '1', '%d')",
            mysqli_real_escape_string($conn, $inquiry),
            mysqli_real_escape_string($conn, $name),
            mysqli_real_escape_string($conn, $email),
            mysqli_real_escape_string($conn, $telefon),
            mysqli_real_escape_string($conn, $user_id)
                    ));

            if(!$result)throw new Exception(mysqli_error($conn));

            if($errorUser_id == false && $errorEmail == false)
            {
                    //Wysłanie email do klienta i doradcy
                    include_once "PHPMailer/PHPMailer.php";
                    include_once "PHPMailer/SMTP.php";
                    include_once "PHPMailer/Exception.php";

                    require_once 'config_smtp.php';
                    //Email Settings =>to advisor
                    $mail->isHTML(true);
                    $mail->CharSet = "UTF-8";
                    $mail->setFrom('info@ubezpieczenia-odszkodowania.pl');
                    $mail->FromName="ubezpieczenia-odszkodowania";
                    $mail->addAddress($user_email);
                    $mail->Subject = "Kontakt od klienta - serwis Ubezpieczenia i Odszkodowania";
                    $mail->Body = "
                        $inquiry 
                        <br><br>$name
                        <br>$email
                        <br>$telefon
                    ";
                    if($mail->send())//jesli wysłano do doradcy, to dopiero wtedy potwierdzenie do klienta
                    {
                        //Email Settings =>to client
                        $mail2->isHTML(true);
                        $mail2->CharSet = "UTF-8";
                        $mail2->setFrom('info@ubezpieczenia-odszkodowania.pl');
                        $mail2->FromName="ubezpieczenia-odszkodowania";
                        $mail2->addAddress($email);
                        $mail2->Subject = "Potwierdzenie nadania e-mail do doradcy - serwis Ubezpieczenia i Odszkodowania";
                        $mail2->Body = "
                            $inquiry 
                            <br><br>$name
                            <br>$email
                            <br>$telefon
                            <br><br>Adresat: $user_surname
                        ";
                        if($mail2->send())
                        {
                            if($result){echo '<span class="form-success">Wiadomość wysłana. Sprawdź potwierdzenie w Twojej skrzynce pocztowej.</span>';}
                            else {throw new Exception(mysqli_error($conn));}
                        }
                        else //doradca dostał, klientowi nie dało rady wysłać
                        {
                            $errorEmail = true;
                            echo '<span class="form-error-contact">Doradca otrzymał Twoją wiadomość, jednak nie udało się wysłać '
                            . ' potwierdzenia do Ciebie. Sprawdź aktualność danych kontaktowych, gdyż może to uniemożliwiać kontakt do Ciebie.</span>';
                            throw new Exception($mail2->ErrorInfo);
                        }

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
            echo '<span class="form-error">Błąd serwera - prosimy o próbę w innym terminie.</span>';
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
    $("#kont_inquiry, #kont_name, #kont_email, #kont_telefon, #kont_regulamin").removeClass("input-error");
    
    var errorEmpty = "<?php echo $errorEmpty; ?>";
    var errorUser_id = "<?php echo $errorUser_id; ?>";
    var errorInquiry = "<?php echo $errorInquiry; ?>";
    var errorName = "<?php echo $errorName; ?>";      
    var errorEmail = "<?php echo $errorEmail; ?>";
    var errorTelefon = "<?php echo $errorTelefon; ?>";
    var errorRegulamin = "<?php echo $errorRegulamin; ?>";
    var errorBot = "<?php echo $errorBot; ?>";
    
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
        $("#kont_email").addClass("input-error");
    }
    if(errorTelefon == true){
        $("#kont_telefon").addClass("input-error");
    }
    if(errorRegulamin == true){
        $("#kont_regulamin").addClass("input-error");
    }
    if(errorEmpty == false && errorInquiry == false && errorName == false && errorEmail == false && errorTelefon == false && errorRegulamin == false && errorBot == false)
    {
        //$("#kont_inquiry, #kont_name, #kont_email, #kont_telefon").val("");
        //$("#kont_regulamin").prop('checked', false);
        $("#kont_inquiry, #kont_name, #kont_email, #kont_telefon, #kont_regulamin, #kont_submit").prop( "disabled", true );
    }
    else
    {
        grecaptcha.reset(); //kasowanie reCapcha
    }
    
</script>