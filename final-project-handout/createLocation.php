<?php

session_start();

require_once("functions.php");

$creationFailed = False;

if ($_SESSION) {
	if (isset($_POST['locationName'])) {
		if (createLocation($_POST['locationName'], $_POST['address'], 
		  $_POST['city'], $_POST['state'], $_POST['zip'])) {
			header("Location: index.php");
			exit();
		}
		else {
			$creationFailed = True;
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Create a Location</title>
</head>
<body>

<?php include "signedInNav.html" ?>

<h1>Create a Location</h1>

<?php
if ($creationFailed) {
	print("<h2>Error: Invalid input</h2>");
}
?>

<form action="createLocation.php" method="post">
  <label>Location Name<input type="text" name="locationName" required autofocus> </label>
  <label>Address<input type="text" name="address" required></label>
  <label>City<input type="text" name="city" required></label>
  <label>State (2 Letter Abbrev)<input type="text" name="state" required></label>
  <label>Zip Code<input type="text" name="zip" required></label>
  <input type="submit" value="Create Location">
</form>

</body>
</html>
