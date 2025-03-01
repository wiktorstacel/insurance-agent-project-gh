<div id="content_kokpit">
	<div style="margin-bottom: 20px;">
                        
        <div class="user_profile_left_title">Zmiana hasła</div>
        <div class="user_profile_right_title">Zachowaj bezpieczeństwo</div>
        <div style="clear:both"></div>
	
        <div id="rejestra_field">
            <div id="res_psw_div">
                <form id="cha_psw_form" method="POST" action="kokpit_pswChangeAction.php">
                        <fieldset>
                        <label for="cha_psw_haslo0">Stare Hasło: </label>
                        <input id="cha_psw_haslo0" type="password" name="new_psw_haslo0" value="" />
                        <br /><br />
                        <label for="cha_psw_haslo">Nowe Hasło: </label>
                        <input id="cha_psw_haslo" type="password" name="cha_psw_haslo" value="" />
                        <br /><br />
                        <label for="cha_psw_haslo2">Powtórz Hasło: </label>
                        <input id="cha_psw_haslo2" type="password" name="cha_psw_haslo2" value="" />
                            <br /><br />
                        <input id="cha_psw_submit" type="submit" value="Zatwierdź" class="btn btn-primary" />
                        <br /><br />
                        <p id="cha_psw_message">Zmień hasło na nowe.</p>
                        </fieldset>
                </form>
            </div>
        </div>
</div>	
</div>