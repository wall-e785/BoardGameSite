<?php

require_once('private/initialize.php');

$errors = [];
$username = '';
$password = '';

// TODO: This page should not show if a session is present.
// Redirect to staff index if a session is detected.
if(isset($_SESSION['username'])) {redirect_to(url_for('BoardGameSite/memberprofile.php'));}


if(is_post_request()) {
  // TODO: Verify the password matches the record
  // if it does not, throw an error message
  // otherwise set the session and redirect to dashboard

  if(!empty($_POST['username']) && !empty($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password']; 

    //check if username exists
    $existing_query = "SELECT COUNT(*) as count FROM Users WHERE username = '" . $username . "'";
    $existing_res = mysqli_query($db, $existing_query);

    if(mysqli_fetch_assoc($existing_res)['count'] != 0){
      $find_user_query = "SELECT hashed_password FROM Users WHERE username ='" . $username . "'";
      $find_user_res = mysqli_query($db, $find_user_query);
      $HASHED_PASSWORD = mysqli_fetch_assoc($find_user_res)['hashed_password'];

      if(password_verify($password, $HASHED_PASSWORD)){
        $_SESSION['username'] = $_POST['username'];
        redirect_to(url_for('BoardGameSite/memberprofile.php'));
      }else{
        array_push($errors, 'Incorrect password, please try again.');
      }

    }else{
      array_push($errors, 'The username entered was not found, please try again.');
    }

  }else{
    array_push($errors, 'Please enter a username AND password.');
  }
  // END TODO
}

?>

<div id="content">
  <h1>Log in</h1>

  <?php echo display_errors($errors); ?>

  <form action="signin.php" method="post">
    Username:<br />
    <input type="text" name="username" value="" /><br />
    Password:<br />
    <input type="password" name="password" value="" /><br />
    <input type="submit" />
  </form>

</div>
