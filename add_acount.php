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
 
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);//zwraca string usuwając (np) polskie znaki
    $regulamin = filter_var($_POST['regulamin'], FILTER_VALIDATE_BOOLEAN);
    
    $errorEmpty = false;
    $errorLogin = false;
    $errorEmail = false;
    $errorHaslo = false;
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
        echo '<span class="form-error">Wprowadź poprawny e-mail!</span>';
        $errorEmail = true;   
    }
    elseif((strlen($haslo) < 8) || (strlen($haslo) > 20))//sprawdz poprawność hasla
    {
        $errorHaslo = true;
        echo '<span class="form-error">Hasło musi posiadać od 8 do 20 znaków!</span>';
    }
    elseif($haslo != $haslo2)//sprawdz zgodność 2 haseł
    {
        $errorHaslo = true;
        echo '<span class="form-error">Podane hasła nie są identyczne!</span>';
    }
    elseif($regulamin != 1)//czy zaakceptowano regulamin
    {
        $errorRegulamin = true;
        echo '<span class="form-error">Potwierdź akceptację regulaminu!</span>';
    }
    //reCapcha do wstawienia jak już będzie wrzucane na serwer, v3 sprawdzającą content strony np artykuły
    elseif(1 == 1)//sprawdz czy nie ma już takiego loginu
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
                //czy email już istnieje
                //UWAGA: trzeba zakończyć poprzednie if'y, bo tutaj nie się sprawdzić warunków tak, żeby
                //wejść do ostatniego else!
                $result = mysqli_query($conn, 
                sprintf("SELECT * FROM users WHERE login='%s'",
                mysqli_real_escape_string($conn, $login)));
                        
                        
                mysqli_close($conn);
            }
        } 
        catch (Exception $ex) 
        {
            echo '<span class="form-error">Błąd serwera - prosimy o rejestrację w innym terminie.</span>';
            echo '<br>Informacja deweloperska: '.$ex;
        }
    }
    else
    {
        //wszystkie testy zaliczone, dodajemy gracza do bazy       
        $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
        echo '<span class="form-success">Success!</span>';
    }
}
else
{
    echo 'Błąd przetwarzania danych!';
}
?>

<script>
    $("#rej_login, #rej_email, #rej_haslo, #rej_haslo2").removeClass("input-error");
    
    var errorEmpty = "<?php echo $errorEmpty; ?>";
    var errorEmail = "<?php echo $errorEmail; ?>";
    
    if(errorEmpty == true){
        $("#rej_login, #rej_email, #rej_haslo, #rej_haslo2").addClass("input-error");
    }
    if(errorEmail == true){
        $("#rej_email").addClass("input-error");
    }
    if((errorEmpty == false) && (errorEmail == false))
    {
        $("#rej_login", "#rej_email", "#rej_haslo", "#rej_haslo2").val("");
    }
    
</script>