$(document).ready(function() {
    var search_input = document.getElementById("search-input");
    var search_button = document.getElementById("make-collection-search");

    //https://stackoverflow.com/questions/1481152/how-to-detect-a-textboxs-content-has-changed
    search_input.addEventListener('input', function(){
         console.log("changed");
         console.log(search_input.value);

        let val = search_input.value;

         $.ajax({
            method: 'POST',
            url: 'private/collection-search.php',
            data: {input: val},
            dataType: 'json',
            success: function(response){
                //referenced looping through json object from: https://stackoverflow.com/questions/25636839/loop-through-a-json-object-in-ajax-response
                let div = document.getElementById("selector-area");
                div.innerHTML = "";
                var count = Object.keys(response).length;

                let to_add = "";
                if(count > 0){
                    for(var row in response){
                        var item = response[row];
                        //referenced more on innerHTML: https://stackoverflow.com/questions/584751/inserting-html-into-a-div
                        to_add += "<label class=\"game-card\"><input type=\"checkbox\" class=\"game-card-input\" name=\"game\" value=\"" + item["game_id"] + "\"> <img src=\"" + item["image_url"] + "\"><p class=\"game-card-title\">" + item['names'] + "</p></label>";
                    }
                    div.innerHTML = to_add;
                }else{
                    div.innerHTML = "<h4>No games found. Try a different search!</h4>";
                }
            }
        });
    });

});