<?php
// TODO 
// 1. Validate that the password fields match
// 2. If the password fields match attempt to insert the data into the database
//    by calling the insertUserRecord function
// 3. If the insertion is successful, then redirect to the sign in page
// 4. If the password fields do match or the insertion fails, then print a
//    message that the input is not valid.
require_once("functions.php");

$creationFailed = False;

//Check if every field is valid because curl can make arbitrary requests
if (
  isset($_POST['user']) &&  
  isset($_POST['email']) &&
  isset($_POST['dob']) &&
  isset($_POST['password1']) &&
  isset($_POST['password2'])
) {
	if ($_POST['password1'] === $_POST['password2']) {
		if (insertUserRecord($_POST['user'], $_POST['email'], $_POST['dob'], $_POST['password1'])) {
			header("Location: sign_in.php");
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
</head>
<body>
<nav>
  <a href="index.php">Home</a>
</nav>

<h1>Create an account</h1>
<?php
if ($creationFailed) {
	print("<h2>Error: Invalid input</h2>");
}
?>
<form action="create_account.php" method="post">
  <label>User Name<input type="text" name="user" required autofocus> </label>
  <label>Email<input type="email" name="email" required></label>
  <label>Date of birth: <input type="date" name="dob" required></label>
  <label>Password<input type="password" name="password1" required></label>
  <label>Retype Password<input type="password" name="password2" required></label>
  <input type="submit" value="Create Account">
</form>

</body>
</html>
