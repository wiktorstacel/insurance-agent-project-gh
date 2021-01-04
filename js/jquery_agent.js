//JQUERY

//sugestia przy wyszukiwarce artykułów na stronie głównej
$(document).ready(function(){
    
    $("#searchinput").keyup(function(){
        var name = $("#searchinput").val();
        $.post("article_searchSuggest.php", {
            suggestion: name 
        }, function(data, status){
            $("#suggestion_answer").html(data);
        });
    });
    
});

//asynchroniczne przesyłanie danych z formularza rejestracji nowego konta
$(document).ready(function(){
    
    $("#rejestra_form").submit(function(event){
        event.preventDefault();                                     //wyłącza domyślne action i method
        var login = $("#rej_login").val();
        var email = $("#rej_email").val();
        var haslo = $("#rej_haslo").val();
        var haslo2 = $("#rej_haslo2").val();
        var gender = $("input[name='gender']:checked").val();        //grup of type"radio"
        //if(gender){alert("Your are a - " + gender);}
        var selectedLanguage = new Array();
        $('input[name="language"]:checked').each(function() {       //kilka checkboxów, gdzie może być zaznaczone od 0 do n
            selectedLanguage.push(this.value);
        });
        var languages = selectedLanguage.toString();
        //alert("Number of selected Languages: "+selectedLanguage.length+"\n"+"And, they are: "+selectedLanguage);
        var regulamin = $("#rej_regulamin").prop('checked');         //checkbox pojedyńczy
        //console.log(regulamin); //wyswietla true lub false, nie da się obsłużyć standardowo isset()
        var submit = $("#rejestra_submit").val();
        $("#rejestra_message").load("register_add_accAction.php", {
            login: login,
            email: email,
            haslo: haslo,
            haslo2: haslo2,
            regulamin: regulamin,
            gender: gender,
            languages: languages,
            submit: submit
        });
    });
    
});

//asynchroniczne przesyłanie danych z formularza odzyskiwania hasła
$(document).ready(function(){
    
    $("#res_psw_form").submit(function(event){
        event.preventDefault();                                     //wyłącza domyślne action i method
        var email = $("#res_psw_email").val();
        var submit = $("#res_psw_submit").val();
        $("#res_psw_message").load("reset_psw_rqstAction.php", {
            email: email,
            submit: submit
        });
    });
    
});

//asynchroniczne przesyłanie danych z formularza tworzenia nowego hasla
$(document).ready(function(){
    
    $("#new_psw_form").submit(function(event){
        event.preventDefault();                                     //wyłącza domyślne action i method
        var selector = $("#new_psw_selector").val();
        var validator = $("#new_psw_validator").val();
        var haslo = $("#new_psw_haslo").val();
        var haslo2 = $("#new_psw_haslo2").val();
        var submit = $("#new_psw_submit").val();
        $("#new_psw_message").load("reset_psw_newAction.php", {
            selector: selector,
            validator: validator,
            haslo: haslo,
            haslo2: haslo2,
            submit: submit
        });
    });
    
});

//asynchroniczny kontakt z plikiem obsługi edycji profilu użytkownika
$(document).ready(function(){
    
    $("#edit_submit").click(function(){
        var login = $("#edit_login").val();
        var email = $("#edit_email").val();
        var surname = $("#edit_surname").val();
        var address = $("#edit_address").val();
        var tel_num = $("#edit_tel_num").val();
        var busi_area = $("#edit_busi_area").val();
        var gender = $("#edit_gender").val();
        var languages = $("#edit_languages").val();
        $.post("kokpit_editProfileAction.php", {
            login: login,
            email: email,
            surname: surname,
            address: address,
            tel_num: tel_num,
            busi_area: busi_area,
            gender: gender,
            languages: languages
        }, function(data, status){
            $("#edit_message").html(data);
        });
    });
    
});

//asynchroniczne przesyłanie danych z formularza zmiany hasła
$(document).ready(function(){
    
    $("#cha_psw_form").submit(function(event){
        event.preventDefault();                                     //wyłącza domyślne action i method
        var login = $("#cha_psw_login").val();
        var haslo0 = $("#cha_psw_haslo0").val();
        var haslo = $("#cha_psw_haslo").val();
        var haslo2 = $("#cha_psw_haslo2").val();
        var submit = $("#cha_psw_submit").val();
        $("#cha_psw_message").load("kokpit_pswChangeAction.php", {
            login: login,
            haslo0: haslo0,
            haslo: haslo,
            haslo2: haslo2,
            submit: submit
        });
    });
    
});