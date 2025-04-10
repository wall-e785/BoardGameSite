<?php
require_once('private/initialize.php');


// TODO: Remove the username session
unset($_SESSION['username']);
// or you could use
// $_SESSION['username'] = NULL;
// End of TODO

redirect_to(url_for('Playtested/index.php'));

?>