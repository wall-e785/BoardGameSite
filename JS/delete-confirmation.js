$(document).ready(function() {
    var delete_button_id = document.getElementById("delete");
    var delete_button_class = document.getElementsByClassName("comment");

    if(delete_button_id){
        delete_button_id.addEventListener('click', function(){
            //referenced confirmation from: https://www.w3schools.com/js/js_popup.asp
            if(delete_button_id.className == "collection"){
                if(confirm("Are you sure you want to delete this collection?")){
                    //redirect referenced from: w3schools.com/howto/howto_js_redirect_webpage.asp
                    window.location.href = delete_button.getAttribute("data-url");
                }
            }
            // 
        });
    }else if(delete_button_class){
        for(var i=0; i<delete_button_class.length; i++){
            delete_button_class[i].addEventListener("click", deleteComment);
        }
    }   

    function deleteComment(){
        if(confirm("Are you sure you want to delete this comment?")){
            //redirect referenced from: w3schools.com/howto/howto_js_redirect_webpage.asp
            window.location.href = this.getAttribute("data-url");
        }
    };
});