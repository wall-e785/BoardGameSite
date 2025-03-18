<?php

require_once('private/initialize.php');

$errors = [];
$username = '';
$password = '';
$email = '';

// TODO: This page should not show if a session is present.
// Redirect to staff index if a session is detected.
if(isset($_SESSION['username'])) {redirect_to(url_for('BoardGameSite/memberprofile.php'));}


if(is_post_request()) {
  // TODO: Verify the password matches the record
  // if it does not, throw an error message
  // otherwise set the session and redirect to dashboard

  if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email'])){
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $email = $_POST['email'];

    //check if username exists
    $existing_query = "SELECT COUNT(*) as count FROM Users WHERE email = '" . $email . "'";
    $existing_res = mysqli_query($db, $existing_query);

    if(mysqli_fetch_assoc($existing_res)['count'] == 0){
        if($password == $_POST['confirm']){
            $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $insert_user_query = "INSERT INTO Users(username, email, hashed_password) VALUES (
                '" . mysqli_real_escape_string($db, $_POST['username']) . "',
                '" . mysqli_real_escape_string($db, $_POST['email']) . "',
                '" . mysqli_real_escape_string($db, $hashed_password) . "')";

            if(mysqli_query($db, $insert_user_query)){
                //INSERT is successful, save a session then redirect to dashboard
                $_SESSION['username'] = $_POST['username'];
                redirect_to(url_for('BoardGameSite/memberprofile.php'));
                }else{
                //Display the mysql error if failed
                array_push($errors, mysqli_error($db));
                }
        }else{
            array_push($errors, 'Password and confirmation do not match!');
        }

    }else{
      array_push($errors, 'Error, this email already has an associated email. Please try logging in instead.');
    }

  }else{
    array_push($errors, 'Please make sure all fields are filled!');
  }
  // END TODO
}

?>

<div id="content">
  <h1>Sign Up</h1>

  <?php echo display_errors($errors); ?>

  <form action="signup.php" method="post">
    Email:<br />
    <input type="email" name="email" value="" /><br />
    Username:<br />
    <input type="text" name="username" value="" /><br />
    Password:<br />
    <input type="password" name="password" value="" /><br />
    Confirm Password:<br />
    <input type="password" name="confirm" value="" /><br />

    <input type="submit" />
  </form>

  <?php
    require_once('private/initialize.php');
    $signinpage = url_for('BoardGameSite/signin.php');
    echo "<a href =" . $signinpage . ">Sign In</a>";
  ?>

</div>
