<div id="rejestra_field">
    <h3 class="title" style="text-align: center;">Utwórz konto</h3>
    <div id="rejestra_div">
        <?php echo register_page::form_begin('register.php', 'POST', 'rejestra_form');?>
        <!--<form action="register.php" method="POST" id="rejestra_form">-->
            <fieldset>
            <?php echo register_page::form_field('Login', 'login', 'text');?>
            <br /><br />
            <?php echo register_page::form_field('E-mail', 'email', 'text');?>
            <br /><br />
            <?php echo register_page::form_field('Twoje Hasło', 'haslo', 'password');?>
            <br /><br />
            <?php echo register_page::form_field('Powtórz Hasło', 'haslo2', 'password');?>
            <br /><br />Płeć: 
            <label id="rej_male" style="padding: 3px 4px 0 0;"><input id="rej_male_inp" type="radio" class="form-check-input" name="gender" value="male"> M</label> 
            <label id="rej_female" style="padding: 3px 4px 0 0;"><input id="rej_female_inp" type="radio" class="form-check-input" name="gender" value="female"> K</label>
            <br /><br />
            <label for="rej_haslo2">Znajomość języków obcych*: </label>
            <br />
            <label><input type="checkbox" class="form-check-input" name="language" id="language1" value="angielski" > angielski </label>
            <label><input type="checkbox" class="form-check-input" name="language" id="language2" value="niemiecki" > niemiecki </label>
            <label><input type="checkbox" class="form-check-input" name="language" id="language3" value="francuski" > francuski </label>
            <label><input type="checkbox" class="form-check-input" name="language" id="language4" value="ukrainski" > ukraiński </label>
            <label><input type="checkbox" class="form-check-input" name="language" id="language5" value="hiszpanski" > hiszpański </label>
            <label><input type="checkbox" class="form-check-input" name="language" id="language6" value="wloski"> włoski </label>
            <label><input type="checkbox" class="form-check-input" name="language" id="language7" value="rosyjski" > rosyjski </label>
            <br /><br />
            <label><input id="rej_regulamin" type="checkbox" class="form-check-input" name="rej_regulamin" /> Akceptuję </label>
            <a href="regulamin.php">regulamin</a>
            <br /><br />
            <div style="width: 304px; margin: auto;" class="g-recaptcha" data-sitekey="6LfV2UUaAAAAAKkcskYoAimOqSAJMW0XLM78uu9d"></div> 
            <br />
            <input id="rejestra_submit" type="submit" value="Utwórz konto" />
            <br /><br />
            <p id="rejestra_message"></p>
        </fieldset>
    <?php echo register_page::form_end();?>
    </div>
</div>