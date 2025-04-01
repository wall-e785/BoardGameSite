//checks if to_check is a keyword (a preset collection)
function not_keyword(to_check){
    if(to_check == "Favourite" || to_check == "Wishlist" || to_check == "Owned"){
        return false;
    }
    return true;
}

//referenced getting all checked boxes from: https://stackoverflow.com/questions/59727296/collect-all-the-values-of-all-checboxes-to-pass-through-ajax
$(document).ready(function() {

    $('#submit').on('click', function(){
        var selected_games = [];
        $('.game:checked').each(function(){
            selected_games.push($(this).val());
        });

        var collect_name = $('.collection-name').val();
        
        if(selected_games.length > 0 && collect_name.trim().length != 0 && not_keyword(collect_name.trim())){
            $.ajax({
                method: 'POST',
                url: 'processcollection.php',
                data: {checked: selected_games, name: collect_name},
                success: function(response){
                    alert(response);
                }
            });
        }else{
            if(selected_games.length <= 0){
                alert("Error creating collection: Please select at least one game!");
            }else if(collect_name.trim().length <=0){
                alert("Error creating collection: Name cannot be blank!");
            }else if(not_keyword(collect_name.trim()) == false){
                alert("Error creating collection: Name already used by pre-made collections!");
            }else{
                alert("Error creating collection: Please try again.");
            }
        }
        
    });
});
