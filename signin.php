<?php
require('header.php');
require_once('private/initialize.php');
require('private/signin-script.php');

// This page should not show if a session is present.
// Redirect to staff index if a session is detected.
if (isset($_SESSION['username'])) {
  redirect_to(url_for('memberprofile.php?user=' . $_SESSION['username']));
}

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