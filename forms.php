<!DOCTYPE html>

<html lang="en">
<head>
	<title>Forms</title>
</head>
<body>

<h1>Form Stuff</h1>

<form action="forms.php" method="get">
	<input type="text" name="user">
	<input type="password" name="password">
	<input type="submit" value="Click for a Surprise">

</form>

<?php
print "<pre>\n";
print_r($_GET);
print_r($_POST);
print "</pre>\n";

print "<p>Hello, ${_GET['user']}</p>";
// ^^ String interpolation within an array
?>

</body>
</html>
