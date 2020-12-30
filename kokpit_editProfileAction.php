<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

if(isset($_POST['email']))
{
    $login = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");
    $email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8");
    $surname = htmlentities($_POST['surname'], ENT_QUOTES, "UTF-8");
    $address = htmlentities($_POST['address'], ENT_QUOTES, "UTF-8");
    $tel_num = htmlentities($_POST['tel_num'], ENT_QUOTES, "UTF-8");
    $busi_area = htmlentities($_POST['busi_area'], ENT_QUOTES, "UTF-8");
    $gender = htmlentities($_POST['gender'], ENT_QUOTES, "UTF-8");
    $languages = htmlentities($_POST['languages'], ENT_QUOTES, "UTF-8");

    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);//zwraca string usuwając (np) polskie znaki
    
    $errorEmpty = false;
    $errorEmail = false;
    $errorSurname = false;
    $errorAddress = false;
    $errorTel_num = false;
    $errorBusi_area = false;
    $errorLanguages = false;
    

    
    if(empty($email))//pole e-mail nie może być puste
    {
        $errorEmpty = true;
        echo '<span class="form-error">E-mail muss sein!</span>';
    }
    elseif ((!filter_var($emailB, FILTER_VALIDATE_EMAIL)) || $email != $emailB) //sprawdz poprawnosc email
    {
        $errorEmail = true;
        echo '<span class="form-error">Wprowadź poprawny e-mail!</span>';   
    }
    elseif(!preg_match("/^(ą|ę| |ź|ć|ń|ó|ś|ż|ł|Ą|Ę|Ź|Ć|Ń|Ó|Ś|Ż|[a-z]|[A-Z]){0,40}$/", $surname))//sprawdź odpowiednie znaki surname
    {
        $errorSurname = true;
        echo '<span class="form-error">Pole "Imię i nazwisko" może składać się tylko z liter(w tym polskich) oraz spacji, 0-40 znaków!</span>';            
    }
    elseif(!preg_match("/^(_|-|ą| |ę|ź|ć|ń|ó|ś|ż|ł|Ą|Ę|Ź|Ć|Ń|Ó|Ś|Ż|[a-z]|[A-Z]|[0-9]){0,150}$/", $address))//sprawdź odpowiednie znaki surname
    {
        $errorAddress = true;
        echo '<span class="form-error">Pole "Adres" może składać się z cyfr, liter(w tym polskich), spacji, znaków specjalnych(-_.,()\/) 0-150 znaków!</span>';            
    }
    else
    {       
        //echo '<span class="form-success">Jeszcze SQL check... </span>';
    }
    
    //dane wejsciowe zwalidowane, sprawdzamy dalsze warunki wykorzystując MySQL
    if($errorEmpty == false && $errorEmail == false && $errorSurname == false && $errorAddress == false && $errorTel_num == false && $errorBusi_area == false && $errorLanguages == false)
    {       
        mysqli_report(MYSQLI_REPORT_STRICT);        
        try
        {
            require_once 'config_db.php';
            if(mysqli_connect_errno($conn) != 0) throw new Exception(mysqli_connect_errno());

            //czy email już istnieje
            $result = mysqli_query($conn, 
            sprintf("SELECT * FROM users WHERE login='%s'",
            mysqli_real_escape_string($conn, $login)));
            if(!$result) throw new Exception(mysqli_error($conn));
            $ile_takich_login = mysqli_num_rows($result);
            $row = mysqli_fetch_assoc($result);
            if($ile_takich_login == 1)
            {                   
                $result = mysqli_query($conn, 
                sprintf("UPDATE users SET `email`='%s', `surname`='%s', `address`='%s', `tel_num`='%s',"
                        . " `busi_area`='%s', `gender`='%s', `languages`='%s'"
                        . "WHERE `login`='%s'",
                mysqli_real_escape_string($conn, $email),
                mysqli_real_escape_string($conn, $surname),
                mysqli_real_escape_string($conn, $address),
                mysqli_real_escape_string($conn, $tel_num),
                mysqli_real_escape_string($conn, $busi_area),
                mysqli_real_escape_string($conn, $gender),
                mysqli_real_escape_string($conn, $languages),
                mysqli_real_escape_string($conn, $row['login'])                        
                        ));

                if($result){echo '<span class="form-success">Zapisano</span>';}
                else {throw new Exception(mysqli_error($conn));}
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
    $("#rej_login, #rej_email, #rej_haslo, #rej_haslo2, #rej_male, #rej_female, #rej_regulamin").removeClass("input-error");
    
    var errorEmpty = "<?php echo $errorEmpty; ?>";
    var errorEmail = "<?php echo $errorEmail; ?>";
    var errorSurname = "<?php echo $errorSurname; ?>";
    var errorAddress = "<?php echo $errorAddress; ?>";
    var errorTel_Num = "<?php echo $errorTel_num; ?>";
    var errorBusi_Area = "<?php echo $errorBusi_area; ?>";
    var errorLanguages = "<?php echo $errorLanguages; ?>";
    
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
    if(errorEmpty == false && errorLogin == false && errorEmail == false && errorHaslo == false && errorHaslo2 == false && errorGender == false && errorRegulamin == false)
    {
        $("#rej_login, #rej_email, #rej_haslo, #rej_haslo2, #rej_male, #rej_female").val("");
        $("#language1, #language2, #language3, #language4, \n\
#language5, #language6, #language7, #rej_male_inp, #rej_female_inp, #rej_regulamin").prop('checked', false);
    }
    
</script>