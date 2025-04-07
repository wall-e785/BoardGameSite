$(document).ready(function() {
    var search_input = document.getElementById("search-input");
    
    //used to add click events to each of the checkboxes
    function add_click_events(){
        var games = document.getElementsByClassName("game-card-input");
        for(let i=0; i<games.length; i++){
            //referneced eventlistener structure from: https://stackoverflow.com/questions/256754/how-to-pass-arguments-to-addeventlistener-listener-function
            games[i].addEventListener('click', function(){
                game_checked(games[i].value);
            });

            //if the searched games have already been selected, set their checked to true
            if (selected.includes(games[i].value)){
                games[i].checked = true;
            }
        }
    }

    //referenced arrays from: https://www.w3schools.com/JS/js_arrays.asp
    var selected = [];
    var remove_this;

    //callback when a checkbox is clicked
    function game_checked(val){
        //if it's not in selected yet, add it to selected
        if(!selected.includes(val)){
            selected.push(val);
        }else{
            //otherwise, it is being deselected.
            //filter the array and remove the game_id
            remove_this = val;
            //referenced filter from: https://www.w3schools.com/jsref/jsref_filter.asp
            let new_selected = selected.filter(deselected);
            selected = new_selected;
        }
    }

    function deselected(val){
        return val != remove_this;
    }

    //referenced input event from https://stackoverflow.com/questions/1481152/how-to-detect-a-textboxs-content-has-changed
    search_input.addEventListener('input', function(){
        //  console.log("changed");
        //  console.log(search_input.value);

        //get the textbox input
        let val = search_input.value;

        //ajax call to get a JSON object of games to display
         $.ajax({
            method: 'POST',
            url: 'private/collection-search.php',
            data: {input: val},
            dataType: 'json',
            success: function(response){
                //referenced looping through json object from: https://stackoverflow.com/questions/25636839/loop-through-a-json-object-in-ajax-response
                let div = document.getElementById("selector-area");
                //clear the div's content
                div.innerHTML = "";

                //count of games
                var count = Object.keys(response).length;

                //keep track of which games will be added to HTML
                let to_add = "";
                if(count > 0){
                    //add each game card to the string
                    for(var row in response){
                        var item = response[row];
                        //referenced more on innerHTML: https://stackoverflow.com/questions/584751/inserting-html-into-a-div
                        to_add += "<label class=\"game-card\"><input type=\"checkbox\" class=\"game-card-input\" name=\"game\" value=\"" + item["game_id"] + "\"> <img src=\"" + item["image_url"] + "\"><p class=\"game-card-title\">" + item['names'] + "</p></label>";
                    }
                    //add the HTML inside the div
                    div.innerHTML = to_add;
                    //add the click events for each of the newly created game cards
                    add_click_events();
                }else{
                    //display message if search returns no results
                    div.innerHTML = "<h4>No games found. Try a different search!</h4>";
                }
            }
        });
    });

    //referenced getting all checked boxes from: https://stackoverflow.com/questions/59727296/collect-all-the-values-of-all-checboxes-to-pass-through-ajax
    $('#save').on('click', function(){
        var collect_name = $('.collection-name').val();
        
        if(selected.length > 0 && collect_name.trim().length != 0){
            $.ajax({
                method: 'POST',
                url: 'processcollection.php',
                data: {checked:selected, name: collect_name},
                success: function(response){
                    alert("Success. Collection created");
                }
            });
        }else{
            if(selected_games.length <= 0){
                alert("Error creating collection: Please select at least one game!");
            }else if(collect_name.trim().length <=0){
                alert("Error creating collection: Name cannot be blank!");
            }else{
                alert("Error creating collection: Please try again.");
            }
        }
        
    });

});