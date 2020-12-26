<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

if(isset($_POST['submit']))
{
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
    

    
    if(empty($login) || empty($email) || empty($haslo) || empty($haslo2))//czy jest jakieś puste pole
    {
        echo '<span class="form-error">Wypełnij wszystkie pola!</span>';
        $errorEmpty = true;
    }
    elseif(strlen($login) < 3 || strlen($login) > 20)//sprawdz długość login
    {
        $errorLogin = true;
        echo '<span class="form-error">Login musi posiadać od 3 do 20 znaków!</span>';
    }
    elseif(ctype_alnum($login) == false)//sprawdź odpowiednie znaki login
    {
        $errorLogin = true;
        echo '<span class="form-error">Login może składać się tylko z liter i cyfr (bez polskich znaków)!</span>';
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
    elseif(!isset($_POST['gender']))//sprawdz zgodność 2 haseł
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
            if(mysqli_connect_errno($conn) != 0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else
            {
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
                    //wszystkie testy zaliczone, dodajemy gracza do bazy
                    $gender = htmlentities($_POST['gender'], ENT_QUOTES, "UTF-8");//tu jest pewność, że ustawiona zmienna POST
                    $result = mysqli_query($conn, 
                    sprintf("INSERT INTO users (`user_id`, `login`, `pass`, `email`, `gender`, `languages`) "
                            . "VALUES (DEFAULT, '%s', '%s', '%s', '%s', '%s')",
                    mysqli_real_escape_string($conn, $login),
                    mysqli_real_escape_string($conn, $haslo_hash),
                    mysqli_real_escape_string($conn, $email),
                    mysqli_real_escape_string($conn, $gender),
                    mysqli_real_escape_string($conn, $languages)
                            ));
                    if($result)
                    {
                        echo '<span class="form-success">Success! Nowe konto utworzone.</span>';
                    }
                    else
                    {
                        throw new Exception(mysqli_error($conn));
                    }
                }
                        
                
                mysqli_close($conn);
            }
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
    var errorLogin = "<?php echo $errorLogin; ?>";
    var errorEmail = "<?php echo $errorEmail; ?>";
    var errorHaslo = "<?php echo $errorHaslo; ?>";
    var errorHaslo2 = "<?php echo $errorHaslo2; ?>";
    var errorGender = "<?php echo $errorGender; ?>";
    var errorRegulamin = "<?php echo $errorRegulamin; ?>";
    
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
    if((errorEmpty == false) && (errorEmail == false))
    {
        $("#rej_login", "#rej_email", "#rej_haslo", "#rej_haslo2").val("");
    }
    
</script>