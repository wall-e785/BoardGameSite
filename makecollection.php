<!--used to create a new collection-->
<!DOCTYPE html>
<html lang="en">

<body>
    <div class="body">
        <?php
        require('header.php');
        require_once('private/initialize.php');

        $errors = [];
        $name = '';
        ?>

        <form>
            <div class="collection-header-container">
                <div class="border-right">
                    <!-- Back URL from https://stackoverflow.com/questions/2548566/go-back-to-previous-page -->
                    <div class="back-button-container">
                        <div class="back-arrow">
                            <?php echo "<a href=\"javascript:history.go(-1)\">"; ?>
                                <svg class="collection-icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="m313-440 196 196q12 12 11.5 28T508-188q-12 11-28 11.5T452-188L188-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l264-264q11-11 27.5-11t28.5 11q12 12 12 28.5T508-715L313-520h447q17 0 28.5 11.5T800-480q0 17-11.5 28.5T760-440H313Z"/></svg></a>
                        </div>
                        <?php echo "<a href=\"javascript:history.go(-1)\">"; ?>
                        <h6>back</h6></a>
                    </div>
                </div>
                <div class="collection-title-container border-right">
                    <h2>New Collection</h2>
                </div>
                <div class="make-collection-save-container">
                    <h3>Save collection:</h3>
                    <button type="submit" id="save" value="Save">Save</button>
                </div>
            </div>

            <div class="collection-createdby-container border-bottom">
                <h3>1. Name your Collection </h3>
                <input type="text" name="name" class="collection-name"
                    placeholder="How would you describe this collection?" />
            </div>

            <div class="make-collection-search-container">

                <h3>2. Select Games</h3>
                <div class="selected-games">
                    <?php
                    // Display only if there is a game selected
                    
                    echo "<p>Selected:</p>";
                    echo "<div class=\"make-collection-wrap\" id=\"selected-games\">";
                    //games here 
                    echo "</div>";

                    ?>
                </div>
                <div class="make-collection-search">
                    <input type="text" name="search" id="search-input" placeholder="Search for games by name here..." />
                </div>

                <div class="make-collection-wrap" id="selector-area">
                </div>
            </div>
        </form>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
<script src="JS/collection-search.js"></script>

</html>