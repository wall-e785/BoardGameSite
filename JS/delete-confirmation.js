$(document).ready(function() {
    var delete_button = document.getElementById("delete");

    if(delete_button){
        delete_button.addEventListener('click', function(){
            //referenced confirmation from: https://www.w3schools.com/js/js_popup.asp
            if(confirm("Are you sure you want to delete this collection?")){
                //redirect referenced from: w3schools.com/howto/howto_js_redirect_webpage.asp
                window.location.href = delete_button.getAttribute("data-url");
            }
            // 
        });
    }
});