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
                            <?php echo "<a href=\"javascript:history.go(-1)\">"; ?><img class="collection-icon"
                                src="./imgs/arrow-left.svg"></a>
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