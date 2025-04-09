$(document).ready(function() {
    //used to confirm deletes of various items

    //id is used for collections (only one for page)
    //class used for comments (many for one page)
    var delete_button_id = document.getElementById("delete");
    var delete_button_class = document.getElementsByClassName("comment");

    //if the delete button for collection was clicked
    if(delete_button_id){
        delete_button_id.addEventListener('click', function(){
            //referenced confirmation from: https://www.w3schools.com/js/js_popup.asp
            //double check it is a collection, then ask for confirmation
            if(delete_button_id.className == "collection"){
                if(confirm("Are you sure you want to delete this collection?")){
                    //redirect referenced from: w3schools.com/howto/howto_js_redirect_webpage.asp
                    window.location.href = delete_button_id.getAttribute("data-url");
                }
            }
            // 
        });
    }else if(delete_button_class){ //if delete button for comments were found
        for(var i=0; i<delete_button_class.length; i++){ //add event listeners to each 
            delete_button_class[i].addEventListener("click", deleteComment);
        }
    }   

    //callback for event listener
    function deleteComment(){
        //ask for confirmation
        if(confirm("Are you sure you want to delete this comment?")){
            //redirect referenced from: w3schools.com/howto/howto_js_redirect_webpage.asp
            window.location.href = this.getAttribute("data-url");
        }
    };
});