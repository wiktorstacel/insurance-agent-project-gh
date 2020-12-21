<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

if(isset($_POST['submit']))
{
    $login = $_POST['login'];
    $email = $_POST['email'];
    $haslo = $_POST['haslo'];
    $haslo2 = $_POST['haslo2'];
    
    $errorEmpty = false;
    $errorEmail = false;
    
    if(empty($login) || empty($email) || empty($haslo) || empty($haslo2))
    {
        echo '<span class="form-error">Wypełnij wszystkie pola!</span>';
        $errorEmpty = true;
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
         echo '<span class="form-error">Wprowadź poprawny e-mail!</span>';
        $errorEmail = true;   
    }
    else
    {
        echo '<span class="form-success">Success!</span>';
        echo $login;
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