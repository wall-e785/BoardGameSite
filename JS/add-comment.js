$(document).ready(function() {
    //find the comment button in the document
    var comment_button = document.getElementById("post-comment");

    //add event to the button
    comment_button.addEventListener("click", function(){

        //get the text area
        let textArea = document.getElementById("comment");
        let content = textArea.value;

        //jquery reference: https://www.w3schools.com/Jquery/jquery_selectors.asp
        //referenced get attribute from: https://www.w3schools.com/jsref/met_element_getattribute.asp
        let game = $(this).attr("data-game-id");

        //ajax call to add comment
        $.ajax({
            method: 'POST',
            url: 'private/add-comment-script.php',
            data: {comment: content, gameid: game},
            success: function(response){
                //reset the text area once comment is posted
                alert(response);
                textArea.value = "";
                //referenced reload: https://www.w3schools.com/jsref/met_loc_reload.asp
                //easily reload the comments once posted   
                location.reload();
            }
        });
    });
});