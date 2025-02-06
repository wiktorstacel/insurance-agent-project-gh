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
    $haslo0 = htmlentities($_POST['haslo0'], ENT_QUOTES, "UTF-8");
    $haslo = htmlentities($_POST['haslo'], ENT_QUOTES, "UTF-8");
    $haslo2 = htmlentities($_POST['haslo2'], ENT_QUOTES, "UTF-8");

    $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
    
    $errorEmpty = false;
    $errorHaslo0 = false;
    $errorHaslo = false;
    $errorHaslo2 = false;

    
    if(empty($haslo0) || empty($haslo) || empty($haslo2))//czy jest jakieś puste pole
    {
        $errorEmpty = true;
        echo '<span class="form-error">Wypełnij wszystkie pola!</span>';
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
    else
    {       
        //echo '<span class="form-success">Jeszcze SQL check... </span>';
    }
    
    
    //dane wejsciowe zwalidowane, sprawdzamy dalsze warunki wykorzystując MySQL
    if($errorEmpty == false && $errorHaslo0 == false && $errorHaslo == false && $errorHaslo2 == false)
    {       
        mysqli_report(MYSQLI_REPORT_STRICT);        
        try
        {
            require_once 'config_db.php';
            if(mysqli_connect_errno() != 0) throw new Exception(mysqli_connect_errno());
            
            //Wyszukanie użytkonika po login
            $result = mysqli_query($conn, 
            sprintf("SELECT * FROM users WHERE login='%s'",
            mysqli_real_escape_string($conn, $login))
                            );
            if(!$result) throw new Exception(mysqli_error($conn));
            
            
            $user_number = mysqli_num_rows($result);
            if($user_number > 0)
            {
                $row = mysqli_fetch_assoc($result);
                if(password_verify($haslo0, $row['pass']) && $row['verifed'] == 1 && $row['login'] == $_SESSION['user'])
                {
                        //wszystkie warunki spełnione - zmiana hasła
                        $result = mysqli_query($conn, 
                        sprintf("UPDATE users SET pass='%s' WHERE login='%s'",
                        mysqli_real_escape_string($conn, $haslo_hash),
                        mysqli_real_escape_string($conn, $login)        
                                ));
                        if(!$result) throw new Exception(mysqli_error($conn));
                        echo '<span class="form-success">Hasło zostało zmienione.</span>';
                }
                else
                {
                    $errorHaslo0 = true;
                    echo '<span class="form-error">Błędne stare hasło!</span>';
                }           
            }
            else
            {
                $errorHaslo0 = true;
                echo '<span class="form-error">Błąd. Ponów próbę!</span>';
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
    $("#cha_psw_haslo0, #cha_psw_haslo, #cha_psw_haslo2").removeClass("input-error");
    
    var errorEmpty = "<?php echo $errorEmpty; ?>";
    var errorHaslo0 = "<?php echo $errorHaslo0; ?>";
    var errorHaslo = "<?php echo $errorHaslo; ?>";
    var errorHaslo2 = "<?php echo $errorHaslo2; ?>";
    
    if(errorEmpty == true){
        $("#cha_psw_haslo0, #cha_psw_haslo, #cha_psw_haslo2").addClass("input-error");
    }
    if(errorHaslo0 == true){
        $("#cha_psw_haslo0").addClass("input-error");
    }
    if(errorHaslo == true){
        $("#cha_psw_haslo").addClass("input-error");
    }
    if(errorHaslo2 == true){
        $("#cha_psw_haslo2").addClass("input-error");
    }
    if(errorEmpty == false && errorHaslo0 == false && errorHaslo == false && errorHaslo2 == false)
    {
        $("#cha_psw_haslo0, #cha_psw_haslo, #cha_psw_haslo2").val("");
        $("#cha_psw_haslo0, #cha_psw_haslo, #cha_psw_haslo2, #cha_psw_submit").prop( "disabled", true );
    }
    
</script>