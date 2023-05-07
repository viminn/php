<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home</title>
</head>
<body>

<?php
// TODO If the session variables exist, then only show a link to the log out
// page, otherwise only show links to the sign in and create account pages.

session_start();

if ($_SESSION) {
	print_r(
	'<nav>
	  <a href="log_out.php">Log Out</a>
	</nav>');
}
else {
	print_r(
	'<nav>
	<a href="sign_in.php">Sign In</a>
	<a href="create_account.php">Create Account</a>
	</nav>');
}

?>

<h1>Home</h1>

<?php
// TODO If the session variables exist then display them as an HTML description
// list, otherwise display a message to sign in or create an account.
if ($_SESSION) {
	print("<dl>");
	foreach ($_SESSION as $k => $v) {
		print("<dt>$k</dt>");
		print("<dd>$v</dd>");	
	}
	print("</dl>");
}
else {
	print("<p>Please sign in or create an account above.</p>");
}
?>

</body>
</html>
