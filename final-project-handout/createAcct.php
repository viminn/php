<?php

require_once("functions.php");

$creationFailed = False;

if (isset($_POST['user'])) {
	if ($_POST['password1'] === $_POST['password2']) {
		if (createAcct($_POST['user'], $_POST['password1'])) {
			header("Location: signIn.php");
			exit();
		}
	}
	else {
		$creationFailed = True;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Create Account</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include "signedOutNav.html" ?>

<h1>Create an account</h1>

<?php
if ($creationFailed) {
	print("<h2>Error: Invalid input</h2>");
}
?>

<form action="createAcct.php" method="post">
  <label>Username<input type="text" name="user" required autofocus> </label>
  <label>Password<input type="password" name="password1" required></label>
  <label>Confirm Password<input type="password" name="password2" required></label>
  <input type="submit" value="Create Account">
</form>

</body>
</html>
