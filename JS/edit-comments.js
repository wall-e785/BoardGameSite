$(document).ready(function() {

    //referenced adding event listeners from: https://stackoverflow.com/questions/19655189/javascript-click-event-listener-on-class
    //add edit button's event listener
    var editButtons = document.getElementsByClassName("edit-button");
    for(var i=0; i<editButtons.length; i++){
        editButtons[i].addEventListener("click", editComment);
    }

    //function for editting comments
   function editComment(){
        //jquery reference: https://www.w3schools.com/Jquery/jquery_selectors.asp
        let button = $(this);
        //referenced get attribute from: https://www.w3schools.com/jsref/met_element_getattribute.asp
        let comment_id = button.attr("data-comment-id");

        //referenced creating a textarea from: https://stackoverflow.com/questions/7377399/creating-a-textarea-with-javascript
        let editField = document.createElement("textarea");
        editField.name = "editing";
        editField.setAttribute("data-comment-id", comment_id);

        //create done button
        let doneButton = document.createElement("button");
        doneButton.type = "button";
        //referenced set attribute from: https://www.w3schools.com/jsref/met_element_setattribute.asp
        doneButton.textContent = "Done";
        doneButton.setAttribute("data-comment-id", comment_id);
        doneButton.classList.add("done-button");
        doneButton.addEventListener("click", saveComment);

        //create cancel button
        let cancelButton = document.createElement("button");
        cancelButton.textContent = "Cancel";
        cancelButton.setAttribute("data-comment-id", comment_id);
        cancelButton.classList.add("cancel-button");
        cancelButton.type = "button";
        cancelButton.addEventListener("click", cancel);

        //referenced replacewith from: https://stackoverflow.com/questions/69701387/using-replacewith-to-replace-an-element-with-a-domstring-or-multiple-elements-in
        //replace edit button with all of the newly created elements
        button.replaceWith(editField, doneButton, cancelButton);
    };

    //used to save comments
    function saveComment(){
        let button = $(this);
        let comment_id = button.attr("data-comment-id");

        //find the textarea with the right commentid
        let textArea = document.querySelector("textarea[data-comment-id=\"" + comment_id + "\"]");
        let newComment = textArea.value;

        //make sure comment is not empty
        if(newComment.length > 0){
            //call deletecomment to run query
            $.ajax({
                method: 'POST',
                url: 'editcomment.php',
                data: {commentid: comment_id, newtext: newComment},
                success: function(response){
                    alert("Success. Comment saved!");
                }
            });

            //remove the cancel button and textarea
            textArea.remove();
            document.querySelector("button[data-comment-id=\"" + comment_id + "\"][class=\"cancel-button\"]").remove();

            //recreate the edit button
            let newButton = document.createElement("button");
            newButton.textContent = "Edit";
            newButton.setAttribute("data-comment-id", comment_id);
            newButton.classList.add("edit-button");
            newButton.type = "button";
            newButton.addEventListener("click", editComment);

            //replace the done button with the edit button
            button.replaceWith(newButton);

            //query selector referenced from: https://stackoverflow.com/questions/14809528/why-does-js-code-var-a-document-queryselectoradata-a-1-cause-error
            //update the comment dynamically
            let commentText = document.querySelector("p[data-comment-id=\"" + comment_id + "\"]")
            commentText.innerHTML = newComment;

        }else{ 
            alert("Error: Comment cannot be empty!");
        }
    }

    //used to cancel editting
    function cancel(){

        let button = $(this);
        let comment_id = button.attr("data-comment-id");

        //remove the done button/text area
        document.querySelector("button[data-comment-id=\"" + comment_id + "\"][class=\"done-button\"]").remove();
        document.querySelector("textarea[data-comment-id=\"" + comment_id + "\"]").remove();

        //recreate the edit button
        let newButton = document.createElement("button");
        newButton.textContent = "Edit";
        newButton.setAttribute("data-comment-id", comment_id);
        newButton.classList.add("edit-button");
        newButton.type = "button";
        newButton.addEventListener("click", editComment);

        //replace the cancel button with the done button
        button.replaceWith(newButton);
    }
});
