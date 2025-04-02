$(document).ready(function() {

    //referenced adding event listenrs from: https://stackoverflow.com/questions/19655189/javascript-click-event-listener-on-class
    var editButtons = document.getElementsByClassName("edit-button");
    for(var i=0; i<editButtons.length; i++){
        editButtons[i].addEventListener("click", editComment);
    }


   function editComment(){
        //jquery reference: https://www.w3schools.com/Jquery/jquery_selectors.asp
        let button = $(this);
        //referenced get attribute from: https://www.w3schools.com/jsref/met_element_getattribute.asp
        let comment_id = button.attr("data-comment-id");

        //referenced creating a textarea from: https://stackoverflow.com/questions/7377399/creating-a-textarea-with-javascript
        let editField = document.createElement("textarea");
        editField.name = "editing";
        editField.id = "new-comment";

        let doneButton = document.createElement("button");
        doneButton.type = "button";
        //referenced set attribute from: https://www.w3schools.com/jsref/met_element_setattribute.asp
        doneButton.textContent = "Done";
        doneButton.setAttribute("data-comment-id", comment_id);
        doneButton.classList.add("done-button");
        doneButton.type = "button";
        doneButton.addEventListener("click", saveComment);

        // cancelButton.textContent = "Cancel";
        // cancelButton.setAttribute("data-comment-id", comment_id);
        // cancelButton.classList.add("cancel-button");

        //referenced replacewith from: https://stackoverflow.com/questions/69701387/using-replacewith-to-replace-an-element-with-a-domstring-or-multiple-elements-in
        button.replaceWith(editField, doneButton);
    };

    function saveComment(){
        console.log("clicked");
        let button = $(this);
        let comment_id = button.attr("data-comment-id");

        let textArea = document.getElementById("new-comment");
        let newComment = textArea.value;


        if(newComment.length > 0){
            $.ajax({
                method: 'POST',
                url: 'deletecomment.php',
                data: {commentid: comment_id, newtext: newComment},
                success: function(response){
                    alert("Success. Comment saved!");
                }
            });
            textArea.remove();

            let newButton = document.createElement("button");
            newButton.textContent = "Edit";
            newButton.setAttribute("data-comment-id", comment_id);
            newButton.classList.add("edit-button");
            newButton.type = "button";
            newButton.addEventListener("click", editComment);

            button.replaceWith(newButton);

            //query selector referenced from: https://stackoverflow.com/questions/14809528/why-does-js-code-var-a-document-queryselectoradata-a-1-cause-error
            let commentText = document.querySelector("p[data-comment-id=\"" + comment_id + "\"]")
            commentText.innerHTML = newComment;

        }else{
            alert("Error: Comment cannot be empty!");
        }
    }
});
