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
