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
        event.preventDefault(); //wyłącza domyślne action i method
        var login = $("#rej_login").val();
        var email = $("#rej_email").val();
        var haslo = $("#rej_haslo").val();
        var haslo2 = $("#rej_haslo2").val();
        //grup of type"radio"
        var gender = $("input[name='gender']:checked").val();
        //if(radioValue){alert("Your are a - " + radioValue);}
        //kilka checkboxów, gdzie może być zaznaczone od 0 do n
        var selectedLanguage = new Array();
        $('input[name="language"]:checked').each(function() {
            selectedLanguage.push(this.value);
        });
        var languages = selectedLanguage.toString();
        alert("Number of selected Languages: "+selectedLanguage.length+"\n"+"And, they are: "+selectedLanguage);
        //checkbox pojedyńczy
        var regulamin = $("#rej_regulamin").prop('checked'); 
        //console.log(regulamin); //wyswietla true lub false, nie da się obsłużyć standardowo isset()
        var submit = $("#rejestra_submit").val();
        $("#rejestra_message").load("add_acount.php", {
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