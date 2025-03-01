<div id="content_kokpit">
		<div style="margin-bottom: 20px;">
	
                    <div class="user_profile_left_title">Profil</div>
                    <div class="user_profile_right_title">Użytkownika</div>
                    <div style="clear:both"></div>
    
                    <div class="user_profile_left">Login</div>
                    <div class="user_profile_right"><input id="edit_login" type="text" name="edit_login" disabled value="<?= htmlspecialchars($userProfile->getLogin(), ENT_QUOTES, 'UTF-8')?>" /></div>
                    <div style="clear:both"></div>

                    <div class="user_profile_left">Adres e-mail</div>
                    <div class="user_profile_right"><input id="edit_email" type="text" name="edit_email" value="<?= htmlspecialchars($userProfile->getEmail(), ENT_QUOTES, 'UTF-8')?>" /></div>
                    <div style="clear:both"></div>

                    <div class="user_profile_left">Imię i Nazwisko</div>
                    <div class="user_profile_right"><input id="edit_surname" type="text" name="edit_surname" value="<?= htmlspecialchars($userProfile->getSurname(), ENT_QUOTES, 'UTF-8')?>" /></div>
                    <div style="clear:both"></div>
                    
                    <div class="user_profile_left">Adres biura</div>
                    <div class="user_profile_right">
                        <textarea name="edit_address" cols="52" rows="2" type="text" value="" id="edit_address" class=""><?= htmlspecialchars($userProfile->getAddress(), ENT_QUOTES, 'UTF-8')?></textarea>
                    </div>
                    <div style="clear:both"></div>
                    
                    <div class="user_profile_left">Numer telefonu</div>
                    <div class="user_profile_right"><input id="edit_tel_num" type="text" name="edit_tel_num" value="<?= htmlspecialchars($userProfile->getTel_num(), ENT_QUOTES, 'UTF-8')?>" /></div>
                    <div style="clear:both"></div>

                    <div class="user_profile_left">Obszar działalności</div>
                    <div class="user_profile_right">
                        <textarea name="edit_busi_area" cols="52" rows="4" type="text" value="" id="edit_busi_area" class=""><?= htmlspecialchars($userProfile->getBusi_area(), ENT_QUOTES, 'UTF-8')?></textarea>
                    </div>
                    <div style="clear:both"></div>                 
                    
                    <div class="user_profile_left">Płeć</div>
                    <div class="user_profile_right">              
                            <select id="edit_gender" class="" name="edit_gender">
                            <?php if(htmlspecialchars($userProfile->getGender(), ENT_QUOTES, 'UTF-8') == "male"): ?>           
                                <option selected="selected" value="male">Mężczyzna</option>
                                <option value="female">Kobieta</option>
                            <?php else: ?>
                                <option selected="selected" value="female">Kobieta</option>
                                <option value="male">Mężczyzna</option>            
                            <?php endif; ?>
                            </select>                      
                    </div>
                    <div style="clear:both"></div>
                    
                    <div class="user_profile_left">Języki obce</div>
                    <div class="user_profile_right">
                    <input class="long_input" id="edit_languages" type="text" name="edit_languages" value="<?= htmlspecialchars($userProfile->getLanguages(), ENT_QUOTES, 'UTF-8')?>" /></div>
                    <div style="clear:both"></div>
                    
                    <div class="user_profile_left">Zatwierdź zmianę danych</div>
                    <div class="user_profile_right"><button id="edit_submit" type="button" class="btn btn-primary">Zapisz</button><br><br><span id="edit_message" ></span></div>
                    <div style="clear:both"></div>
		
	    </div>
		
	</div>