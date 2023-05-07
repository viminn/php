<?php
// TODO
// 1. If the form values are set, then get the user record from the database
//    by calling the getUserRecord function.
// 2. If a record is returned, then store each of the values in session
//    variable and redirect to the home page.
// 3. If a record is not returned, then print a message that the email and
//    password combination is not valid.
require_once("functions.php");

$failedLogin = False;

if (isset($_POST['email']) && isset($_POST['password'])) {
	$result = getUserRecord($_POST['email'], $_POST['password']);	
	if ($result) {
		session_start();
		$_SESSION += $result;
		header("Location: index.php");
		exit();
	}
	else {
		$failedLogin = True;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home</title>
</head>
<body>
<nav>
  <a href="index.php">Home</a>
</nav>
<h1>Sign In</h1>

<?php
if ($failedLogin) {
	print("<h2>Error: Invalid login information</h2>");
}
?>

<form action="sign_in.php" method="post">
    <label>User <input type="email" name="email" required autofocus></label>
    <br>
    <label>Password <input type="password" name="password" required></label>
    <br>
    <input type="submit" value="Sign In">
</form>

</body>
</html>
