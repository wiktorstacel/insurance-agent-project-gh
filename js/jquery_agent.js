//JQUERY

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

$(document).ready(function(){
    
    $("#rejestra_form").submit(function(event){
        event.preventDefault(); //wyłącza domyślne action i method
        var login = $("#rej_login").val();
        var email = $("#rej_email").val();
        var haslo = $("#rej_haslo").val();
        var haslo2 = $("#rej_haslo2").val();
        var submit = $("#rejestra_submit").val();
        $("#rejestra_message").load("add_acount.php", {
            login: login,
            email: email,
            haslo: haslo,
            haslo2: haslo2,
            submit: submit
        });
    });
    
});