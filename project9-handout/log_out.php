<?php
// TODO destroy the session variables and redirect to the home page

session_start();

session_unset();

session_destroy();

header("Location: index.php");
exit();

?>
