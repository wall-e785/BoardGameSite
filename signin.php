<?php


require('header.php');
require_once('private/initialize.php');
require('private/signin-script.php');
// $errors = [];
// $username = '';
// $password = '';

// TODO: This page should not show if a session is present.
// Redirect to staff index if a session is detected.
if(isset($_SESSION['username'])) {redirect_to(url_for('BoardGameSite/memberprofile.php'));}


// if(is_post_request()) {
//   // TODO: Verify the password matches the record
//   // if it does not, throw an error message
//   // otherwise set the session and redirect to dashboard

//   if(!empty($_POST['username']) && !empty($_POST['password'])){ //both username/password entered
//     $username = $_POST['username'];
//     $password = $_POST['password']; 

//     //check if username exists
//     $existing_username_query = "SELECT COUNT(*) as count FROM Users WHERE username = '" . $username . "'";
//     $existing_username_res = mysqli_query($db, $existing_username_query);

//     //also check if they entered an email
//     $existing_email_query = "SELECT COUNT(*) as count FROM Users WHERE email = '" . $username . "'";
//     $existing_email_res = mysqli_query($db, $existing_email_query);

//     if(mysqli_fetch_assoc($existing_username_res)['count'] != 0){ //if they entered a valid username

//       //free the results for email to clear up memory
//       mysqli_free_result($existing_email_res);

//       //select the associated password
//       $find_user_query = "SELECT hashed_password FROM Users WHERE username ='" . $username . "'";
//       $find_user_res = mysqli_query($db, $find_user_query);
//       $HASHED_PASSWORD = mysqli_fetch_assoc($find_user_res)['hashed_password'];

//       //verify the password
//       if(password_verify($password, $HASHED_PASSWORD)){
//         $_SESSION['username'] = $_POST['username'];
//         redirect_to(url_for('BoardGameSite/memberprofile.php'));
//       }else{
//         array_push($errors, 'Incorrect password, please try again.');
//       }

//     }else if(mysqli_fetch_assoc($existing_email_res)['count'] != 0){ //if they entered a valid email

//       //select the associated password
//       $find_user_query = "SELECT hashed_password FROM Users WHERE email ='" . $username . "'";
//       $find_user_res = mysqli_query($db, $find_user_query);
//       $HASHED_PASSWORD = mysqli_fetch_assoc($find_user_res)['hashed_password'];
    
//       //verify the password
//       if(password_verify($password, $HASHED_PASSWORD)){
//         //get the username to setup the session
//         $find_username_query = "SELECT username FROM Users WHERE email ='" . $username . "'";
//         $find_username_res = mysqli_query($db, $find_username_query);
//         $USERNAME = mysqli_fetch_assoc($find_username_res)['username'];
  
//         $_SESSION['username'] = $USERNAME;
//         redirect_to(url_for('BoardGameSite/memberprofile.php'));
//       }else{
//         array_push($errors, 'Incorrect password, please try again.');
//       }
//     }else{
//       array_push($errors, 'The username or email entered was not found, please try again.');
//     }
//   }else{
//     array_push($errors, 'Please enter a valid username AND password.');
//   }
// }

?>

<div class="body">

<div class="signin-body">
  <div class="border-right signin-item-container" id="signup">
    <div class="signin-item">
    <h2>Sign up</h2>

      <?php echo display_errors($signupErrors); ?>

      <form action="signin.php" method="post">
        Email:<br />
        <input type="email" name="signup-email" value="" /><br />
        Username:<br />
        <input type="text" name="signup-username" value="" /><br />
        Password:<br />
        <input type="password" name="signup-password" value="" /><br />
        Confirm Password:<br />
        <input type="password" name="signup-confirm" value="" /><br />
        <input name="signup-submit" type="submit" />
      </form>
    </div>
  </div>

  <div class="signin-item-container" id="login">
    <div class="signin-item">
      <h2>Log in</h2>

      <?php echo display_errors($signinErrors); ?>

      <form action="signin.php" method="post">
        Username or Email:<br />
        <input type="text" name="login-username" value="" /><br />
        Password:<br />
        <input type="password" name="login-password" value="" /><br />
        <input name="login-submit" type="submit" />
      </form>
    </div>
    
  </div>
</div>
</div>

