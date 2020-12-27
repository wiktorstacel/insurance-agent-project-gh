//JQUERY

//sugestia przy wyszukiwarce artykułów na stronie głównej
$(document).ready(function(){
    
    $("#searchinput").keyup(function(){
        var name = $("#searchinput").val();
        $.post("suggestion.php", {
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
        $("#rejestra_message").load("add_account.php", {
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
        $("#res_psw_message").load("reset_psw_rqst.php", {
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
        $("#new_psw_message").load("reset_psw_action.php", {
            selector: selector,
            validator: validator,
            haslo: haslo,
            haslo2: haslo2,
            submit: submit
        });
    });
    
});