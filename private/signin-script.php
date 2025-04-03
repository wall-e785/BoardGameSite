<?php
    $signupErrors = [];
    $signinErrors = [];
    $username = '';
    $password = '';

    if(is_post_request()) {
        // login request
        if (isset($_POST['login-submit'])) {
            if(!empty($_POST['login-username']) && !empty($_POST['login-password'])){ //both username/password entered
                $username = $_POST['login-username'];
                $password = $_POST['login-password']; 

                //check if username exists
                $existing_username_query = "SELECT COUNT(*) as count FROM Users WHERE username = '" . $username . "'";
                $existing_username_res = mysqli_query($db, $existing_username_query);

                //also check if they entered an email
                $existing_email_query = "SELECT COUNT(*) as count FROM Users WHERE email = '" . $username . "'";
                $existing_email_res = mysqli_query($db, $existing_email_query);

                if(mysqli_fetch_assoc($existing_username_res)['count'] != 0){ //if they entered a valid username

                //free the results for email to clear up memory
                mysqli_free_result($existing_email_res);

                //select the associated password
                $find_user_query = "SELECT hashed_password FROM Users WHERE username ='" . $username . "'";
                $find_user_res = mysqli_query($db, $find_user_query);
                $HASHED_PASSWORD = mysqli_fetch_assoc($find_user_res)['hashed_password'];

                //verify the password
                if(password_verify($password, $HASHED_PASSWORD)){
                    $_SESSION['username'] = $_POST['login-username'];
                    redirect_to(url_for('BoardGameSite/memberprofile.php'));
                }else{
                    array_push($signinErrors, 'Incorrect password, please try again.');
                }

                }else if(mysqli_fetch_assoc($existing_email_res)['count'] != 0){ //if they entered a valid email

                //select the associated password
                $find_user_query = "SELECT hashed_password FROM Users WHERE email ='" . $username . "'";
                $find_user_res = mysqli_query($db, $find_user_query);
                $HASHED_PASSWORD = mysqli_fetch_assoc($find_user_res)['hashed_password'];
                
                //verify the password
                if(password_verify($password, $HASHED_PASSWORD)){
                    //get the username to setup the session
                    $find_username_query = "SELECT username FROM Users WHERE email ='" . $username . "'";
                    $find_username_res = mysqli_query($db, $find_username_query);
                    $USERNAME = mysqli_fetch_assoc($find_username_res)['username'];
            
                    $_SESSION['username'] = $USERNAME;
                    redirect_to(url_for('BoardGameSite/memberprofile.php'));
                }else{
                    array_push($signinErrors, 'Incorrect password, please try again.');
                }
                }else{
                array_push($signinErrors, 'The username or email entered was not found, please try again.');
                }
            }else{
                array_push($signinErrors, 'Please enter a valid username AND password.');
            }
        }


        // TODO: Verify the password matches the record
        // if it does not, throw an error message
        // otherwise set the session and redirect to dashboard
        if (isset($_POST['signup-submit'])) {
            if(!empty($_POST['signup-username']) && !empty($_POST['signup-password']) && !empty($_POST['signup-email'])){
                $username = $_POST['signup-username'];
                $password = $_POST['signup-password']; 
                $email = $_POST['signup-email'];

                //check if username exists
                $existing_query = "SELECT COUNT(*) as count FROM Users WHERE email = '" . $email . "'";
                $existing_res = mysqli_query($db, $existing_query);

                if(mysqli_fetch_assoc($existing_res)['count'] == 0){
                    if($password == $_POST['signup-confirm']){
                        $hashed_password = password_hash($_POST['signup-password'], PASSWORD_DEFAULT);
                        $insert_user_query = "INSERT INTO Users(username, email, hashed_password) VALUES (
                            '" . mysqli_real_escape_string($db, $_POST['signup-username']) . "',
                            '" . mysqli_real_escape_string($db, $_POST['signup-email']) . "',
                            '" . mysqli_real_escape_string($db, $hashed_password) . "')";

                        if(mysqli_query($db, $insert_user_query)){
                            //INSERT is successful, save a session then redirect to dashboard
                            $_SESSION['username'] = $_POST['signup-username'];
                            redirect_to(url_for('BoardGameSite/memberprofile.php'));
                            }else{
                            //Display the mysql error if failed
                            array_push($signupErrors, mysqli_error($db));
                            }
                    }else{
                        array_push($signupErrors, 'Password and confirmation do not match!');
                    }

                }else{
                array_push($signupErrors, 'Error, this email already has an associated email. Please try logging in instead.');
                }
            }else{
                array_push($signupErrors, 'Please make sure all fields are filled!');
            }
        }
        // END TODO
    }
?>
