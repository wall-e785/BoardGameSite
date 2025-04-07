$(document).ready(function() {
    var comment_button = document.getElementById("post-comment");

    comment_button.addEventListener("click", function(){

        let textArea = document.getElementById("comment");
        let content = textArea.value;

        //jquery reference: https://www.w3schools.com/Jquery/jquery_selectors.asp
        //referenced get attribute from: https://www.w3schools.com/jsref/met_element_getattribute.asp
        let game = $(this).attr("data-game-id");

        $.ajax({
            method: 'POST',
            url: 'private/add-comment-script.php',
            data: {comment: content, gameid: game},
            success: function(response){
                alert(response);
            }
        });
    });
});