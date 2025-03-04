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
        var regulamin = $("#rej_regulamin").prop('checked');         //checkbox pojedyńczy - uwaga wystawia "true" lub "false" i potrzeba w PHP FILTER_VALIDATE_BOOLEAN, że rozpoznawało jako boolean
        //console.log(regulamin); //wyswietla true lub false, nie da się obsłużyć standardowo isset() //register_add_accAction.php
        var captchaResponse = grecaptcha.getResponse();
        var submit = $("#rejestra_submit").val();
        $.post("register.php", {
            login: login,
            email: email,
            haslo: haslo,
            haslo2: haslo2,
            regulamin: regulamin,
            captchaResponse: captchaResponse,
            gender: gender,
            languages: languages,
            submit: submit
        }, function(response) { //Przetwarzanie JSON otrzymanego od PHP
            //$("#rejestra_message").html(response);
            $("#rej_login, #rej_email, #rej_haslo, #rej_haslo2, #rej_male, #rej_female, #rej_regulamin").removeClass("input-error");
            for (let key in response) { //iteracja po error gdyż indeksy zawierające message np 'empty', 'login itd. mogą być różne
                if (response.hasOwnProperty(key)) {
                    $("#rejestra_message").html("<p style='color: red;'>" + response[key] + "</p>");
                    if (key == 'gender') {
                        $("#rej_male, #rej_female").addClass("input-error");
                    } else {
                        $("#rej_"+key).addClass("input-error");
                    }
                    break; // Zatrzymuje się po pierwszym błędzie
                }
            }
            if (response.success) {
                $("#rejestra_message").html("<p style='color: green;'>" + response.success + "</p>");
                $("#rej_login, #rej_email, #rej_haslo, #rej_haslo2, #rej_male, #rej_female").val("");
                $("#language1, #language2, #language3, #language4, \n\
                #language5, #language6, #language7, #rej_male_inp, #rej_female_inp, #rej_regulamin").prop('checked', false);
            }
        }, "json");//*/});
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
//walidacja i zapis (nie ładowanie danych)
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
        $.post("kokpit_editProfile.php", {
            //login: login, - login ma nie być walidowany ani updatowany - input disabled by go nie wysłało POSTem
            email: email, //- chwilę była zablokowana zmiana e-mail, bo przeba by zrobić wysyłanie tokena do potwierdzenia
            surname: surname,
            address: address,
            tel_num: tel_num,
            busi_area: busi_area,
            gender: gender,
            languages: languages
        }, function(response){
            //$("#edit_message").html(response);
            $("#edit_email, #edit_surname, #edit_address, #edit_tel_num, #edit_busi_area, #edit_languages").removeClass("input-error");
            for (let key in response) { //iteracja po error gdyż indeksy zawierające message np 'empty', 'login itd. mogą być różne
                if (response.hasOwnProperty(key)) {
                    $("#edit_message").html("<p style='color: red;'>" + response[key] + "</p>");
                    $("#edit_"+key).addClass("input-error");
                    break;
                }
            }
            if (response.success) {
                $("#edit_message").html("<p style='color: green;'>" + response.success + "</p>");
                $("#edit_email, #edit_surname, #edit_address, #edit_tel_num, #edit_busi_area, #edit_gender, #edit_languages, #edit_submit").prop( "disabled", true );
            }
        }, "json");//*/});
    });
    
});

//asynchroniczne przesyłanie danych z formularza zmiany hasła
$(document).ready(function(){
    
    $("#cha_psw_form").submit(function(event){
        event.preventDefault();                                     //wyłącza domyślne action i method
        //var login = $("#cha_psw_login").val();
        var haslo0 = $("#cha_psw_haslo0").val();
        var haslo = $("#cha_psw_haslo").val();
        var haslo2 = $("#cha_psw_haslo2").val();
        var submit = $("#cha_psw_submit").val();
        $.post("kokpit_pswChange.php", {
            //login: login,
            haslo0: haslo0,
            haslo: haslo,
            haslo2: haslo2,
            submit: submit
        }, function(response){
            //$("#cha_psw_message").html(response);
            $("#cha_psw_haslo0, #cha_psw_haslo, #cha_psw_haslo2").removeClass("input-error");
            for (let key in response) { //iteracja po error gdyż indeksy zawierające message np 'empty', 'login itd. mogą być różne
                if (response.hasOwnProperty(key)) {
                    $("#cha_psw_message").html("<p style='color: red;'>" + response[key] + "</p>");
                    $("#cha_psw_"+key).addClass("input-error");
                    break;
                }
            }
            if (response.success) {
                $("#cha_psw_message").html("<p style='color: green;'>" + response.success + "</p>");
                $("#cha_psw_haslo0, #cha_psw_haslo, #cha_psw_haslo2").val("");
                $("#cha_psw_haslo0, #cha_psw_haslo, #cha_psw_haslo2, #cha_psw_submit").prop( "disabled", true );
            }
        }, "json");//*/});
    });
    
});

//wstawienie formularza kontaktowego po naciśnięciu "Napisz Wiadomość"
$(document).ready(function(){

    $(document).on("click", ".kontaktform_loadButt", function(){
        var user_id = $(this).val(); 
        $(".kontaktform_loadButt").prop( "disabled", true );//wyłączenie wszystkich innych "Napisz Wiadomość"
        var pole = "#kontaktform_div"+user_id; 
        $(pole).load("contact_formLoad.php?" + $.param( { //? oraz $.param - zamiana na metodę GET przy load
            user_id: user_id
            }), function(){
                    grecaptcha.render('captcha_container', {
                        'sitekey': '6LfV2UUaAAAAAKkcskYoAimOqSAJMW0XLM78uu9d'
                    });
                } 
        );
        
        /*setTimeout(function() {
        grecaptcha.render('captcha_container', {
          'sitekey': '6LfV2UUaAAAAAKkcskYoAimOqSAJMW0XLM78uu9d',
        });
        }, 500);*/
        
        //EXAMPLE - not connected data
        /*$("#result").load("feeds.php", { limit: 25 }, function() {
        //funkcja zwrotna odpalana po wczytaniu
        $("#result").slideDown();
        });*/
    });
    
});

// requests.post(url, data=data) will make an HTTP POST request, and
// requests.get(url, params=params) will make an HTTP GET request
/*$("#output").load(
    "server_output.html?" + $.param({
        year: 2009,
        country: "Canada"})
);*/

//asynchroniczne przesyłanie danych z formularza kontaktu klienta z doradcą
$(document).ready(function(){
    
    $(document).on("submit", "#kont_form", function(event){
        event.preventDefault(); 
        var user_id= $("#kont_user_id").val();//wyłącza domyślne action i method
        var inquiry= $("#kont_inquiry").val();
        var name= $("#kont_name").val();
        var email = $("#kont_email").val();
        var telefon = $("#kont_telefon").val();
        var regulamin = $("#kont_regulamin").prop('checked');
        //console.log(regulamin); //wyswietla true lub false, nie da się obsłużyć standardowo isset()
        var captchaResponse = grecaptcha.getResponse();
        var submit = $("#kont_submit").val();
        $("#kont_message").load("contact_formLoadAction.php", {
            user_id: user_id,
            inquiry: inquiry,
            name: name,
            email: email,
            telefon: telefon,
            regulamin: regulamin,
            captchaResponse: captchaResponse,
            submit: submit
        });
    });
    
});
