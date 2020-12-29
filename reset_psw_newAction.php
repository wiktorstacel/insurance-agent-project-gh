<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//session_start();

if(isset($_POST['submit']))
{
    $haslo = htmlentities($_POST['haslo'], ENT_QUOTES, "UTF-8");
    $haslo2 = htmlentities($_POST['haslo2'], ENT_QUOTES, "UTF-8");
    $selector = htmlentities($_POST['selector'], ENT_QUOTES, "UTF-8");
    $validator = htmlentities($_POST['validator'], ENT_QUOTES, "UTF-8");

    $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
    
    $errorEmpty = false;
    $errorHaslo = false;
    $errorHaslo2 = false;

    
    if(empty($haslo) || empty($haslo2))//czy jest jakieś puste pole
    {
        echo '<span class="form-error">Wypełnij wszystkie pola!</span>';
        $errorEmpty = true;
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
    if($errorEmpty == false && $errorHaslo == false && $errorHaslo2 == false)
    {       
        mysqli_report(MYSQLI_REPORT_STRICT);        
        try
        {
            require_once 'config_db.php';
            if(mysqli_connect_errno($conn) != 0) throw new Exception(mysqli_connect_errno());
            
            $currentDate = date("U");
            
            //Czy w tabeli pswReset jest taki selektor i jego data użycia nie wygasła
            $result = mysqli_query($conn, 
                sprintf("SELECT * FROM pswReset WHERE pswResetSelector='%s' AND pswResetExpires > '%s'",
                mysqli_real_escape_string($conn, $selector),
                mysqli_real_escape_string($conn, $currentDate)
                        ));
            if(!$result) throw new Exception(mysqli_error($conn));
            //użytkownika rozpoznajemy po selektorze, 1 user może mieć nie 
            //więcej niż jeden wpis w tej tabeli w jednym czasie
            if(!$row = mysqli_fetch_assoc($result)) //brak wniosku w db tego usera z jakiegoś powodu
            {
                echo '<span class="form-error">Błąd. Ponów wniosek o wysłanie linku odzyskania hasła!</span>';
            }
            else
            {
                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $row['pswResetToken']);
                if($tokenCheck === false)
                {
                    echo '<span class="form-error">Błąd. Niezgodność danych!</span>';
                }
                elseif($tokenCheck === true)
                {
                    $tokenEmail = $row['pswResetEmail'];
                    
                    $result = mysqli_query($conn, 
                        sprintf("SELECT * FROM users WHERE email='%s'",
                        mysqli_real_escape_string($conn, $tokenEmail)
                                ));
                    if(!$result) throw new Exception(mysqli_error($conn));
                    if(!$row = mysqli_fetch_assoc($result))
                    {
                        echo '<span class="form-error">Błąd. Nieznaleziono e-maila w bazie użytkowników!</span>';
                    }
                    else //jest taki email w bazie
                    {
                        $result = mysqli_query($conn, 
                        sprintf("UPDATE users SET pass='%s' WHERE email='%s'",
                        mysqli_real_escape_string($conn, $haslo_hash),
                        mysqli_real_escape_string($conn, $tokenEmail)        
                                ));
                        if(!$result) throw new Exception(mysqli_error($conn));
                        
                        echo '<span class="form-success">Hasło zmienione. Przejdź do strony logowania.<br>'
                            . '<a href="login.php">Logowanie</a></span>';

                        $result = mysqli_query($conn, 
                        sprintf("DELETE FROM pswReset WHERE pswResetEmail='%s'",
                        mysqli_real_escape_string($conn, $tokenEmail)));
                        if(!$result) throw new Exception(mysqli_error($conn));
                    }                   

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
    $("#new_psw_haslo, #new_psw_haslo2").removeClass("input-error");
    
    var errorEmpty = "<?php echo $errorEmpty; ?>";
    var errorHaslo = "<?php echo $errorHaslo; ?>";
    var errorHaslo2 = "<?php echo $errorHaslo2; ?>";
    
    if(errorEmpty == true){
        $("#new_psw_haslo, #new_psw_haslo2").addClass("input-error");
    }
    if(errorHaslo == true){
        $("#new_psw_haslo").addClass("input-error");
    }
    if(errorHaslo2 == true){
        $("#new_psw_haslo2").addClass("input-error");
    }
    if(errorEmpty == false && errorHaslo == false && errorHaslo2 == false)
    {
        $("#new_psw_haslo, #new_psw_haslo2").val("");
        $("#new_psw_haslo, #new_psw_haslo2, #new_psw_submit").prop( "disabled", true );
    }
    
</script>