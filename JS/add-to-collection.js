$(document).ready(function() {
    //find the add-to-collection button
    var add_button = document.getElementById("add-collection");

    //add event listener to the button for clicks
    add_button.addEventListener("click", function(){
        //get the collection val from the dropdown
        //referenced from: https://stackoverflow.com/questions/1085801/get-selected-value-in-dropdown-list-using-javascript
        let val = document.getElementById("add-to-collection").value;

        //jquery reference: https://www.w3schools.com/Jquery/jquery_selectors.asp
        //referenced get attribute from: https://www.w3schools.com/jsref/met_element_getattribute.asp
        let game = $(this).attr("data-game-id");

        //ajax call to add collection
        $.ajax({
            method: 'POST',
            url: 'private/add-to-collection-script.php',
            data: {collection_id: val, gameid: game},
            success: function(response){
                //show response in an alert
                alert(response);
            }
        });
    });
});