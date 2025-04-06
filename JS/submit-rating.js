$(document).ready(function() {
    var rate_button = document.getElementById("submit-rating");

    rate_button.addEventListener("click", function(){
        //get the rating val from the dropdown
        //referenced from: https://stackoverflow.com/questions/1085801/get-selected-value-in-dropdown-list-using-javascript
        let val = document.getElementById("rating").value;

        //jquery reference: https://www.w3schools.com/Jquery/jquery_selectors.asp
        //referenced get attribute from: https://www.w3schools.com/jsref/met_element_getattribute.asp
        let game = $(this).attr("data-game-id");

        $.ajax({
            method: 'POST',
            url: 'private/submit-rating-script.php',
            data: {rating: val, gameid: game},
            success: function(response){
                alert("Success. Rating submitted!" + response);
            }
        });
    });
});