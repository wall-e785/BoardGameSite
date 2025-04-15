<!DOCTYPE html>
<html lang="en">

<body>
    <?php
    require('header.php');
    require_once('private/initialize.php');
    include('private/settings-script.php');
    $username = $_GET['username'];
    $current_user = $_SESSION['username'];

    $user_query_str = "SELECT * FROM `Users` WHERE username='" . $current_user . "'";
    $res = mysqli_query($db, $user_query_str);
    $email = null;
    if (mysqli_num_rows($res) > 0) {
        // Looping through collections that user has
        while ($row = $res->fetch_assoc()) {
            $email = $row['email'];
        }
    }
    // Free the result 
    $res->free_result();

    ?>
    <div class="body">
        <?php
        // Confirm that the current user matches the user settings page
        if ($username == $current_user) { ?>

            <div class="profile-header border-bottom">
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
                <div class="border-right" id="username">
                    <div class="username">
                        <?php echo "<h2>Settings</h2>"; ?> <!-- Display username -->
                    </div>
                </div>
            </div>

            <form action="" method="POST">
                <!-- For future updates, we would like to add a more fleshed out settings page: -->
                <!-- <div>
                    <h3>Username</h3>
                    <label for="new-username">Username:</label>
                    <input type="text" name="new-username" value="<?php echo $username; ?>" />
                </div>
                <div>
                    <h3>Password</h3>
                    <label for="current-password">Current Password:</label>
                    <input type="text" name="current-password" />
                    <label for="new-password">New Password:</label>
                    <input type="text" name="new-password" />
                    <label for="new-password-confirm">Confirm New Password:</label>
                    <input type="text" name="new-password-confirm" />
                </div>
                <div>
                    <h3>Email</h3>
                    <label for="new-email">Email:</label>
                    <input type="text" name="new-email" value="<?php echo $email; ?>" />
                </div>
                 -->
                <button style="margin:2em 3em;" name="delete_account" type="submit" onclick="return confirmDelete();">Delete
                    account</button>
                <!-- <input type="submit" id="save" value="Save"/> -->

            </form>

        <?php } else
            // The current user is trying to access settings for a different account, which we don't want to allow   
            echo "<p>You do not have permission to view this page.</p>";
        ?>

    </div>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete your account? This action cannot be undone.");
        }
    </script>
</body>

</html>