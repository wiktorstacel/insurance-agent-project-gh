<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_GET['user_id']))
{
    $user_id = htmlentities($_GET['user_id'], ENT_QUOTES, "UTF-8");
    require_once 'config_db.php';
    $result = mysqli_query($conn, 
        sprintf("SELECT * FROM users WHERE user_id='%s'",
        mysqli_real_escape_string($conn, $user_id)));
    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
    $row = mysqli_fetch_assoc($result);

?>

    <form id="kont_form" method="POST" action="contact_formLoadAction.php">
            <fieldset>
            <img src="css\images\envelop2.png" width="32" height="32" alt="alt"/>
            <input id="kont_user_id" type="hidden" name="kont_user_id" value="<?php echo $row['user_id']?>" />
            <label for="kont_login"><u>Wiadomość do:</u> <b><?php echo $row['surname'].'</b>, '.$row['address']?></label>
                
            <br>
            <br><textarea name="kont_inquiry" cols="56" rows="6" type="text" value="" id="kont_inquiry" placeholder="Treść zapytania... prośby o przedstawienie oferty... wniosku o umówienie spotkania..." class=""></textarea>
            
            <br><br><label for="kont_login">Imię: </label>
            <input id="kont_name" type="text" name="kont_name" value="" />
            <br /><br />
            <label for="rejs_email">E-mail: </label>
            <input id="kont_email" type="text" name="kont_email" value="" />
            <br /><br />
            <label for="rej_haslo">Telefon*: </label>
            <input id="kont_telefon" type="text" name="kont_telefon" value="" />
            <br /><br />

            <label><input id="kont_regulamin" type="checkbox" name="kont_regulamin" />Akceptuję </label>
            <a href="regulamin.php">regulamin</a>
            <br /><br />
            <div id="captcha_container" class="google-cpatcha"></div>
            <br />
            <input id="kont_submit" type="submit" value="Wyślij" />
            <br />
            <p id="kont_message"></p>
            </fieldset>
    </form>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
    </script>

<?php
}
else
{
    echo 'Błąd przetwarzania danych!';
}