<!DOCTYPE html>
<html lang=en>
  <head>
    <title>Search</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
<?php include "nav.html" ?>

<?php
$s_name = isset($_GET['category']) && $_GET['category'] === 'name';
$s_email = isset($_GET['category']) && $_GET['category'] === 'email';
$s_dob = isset($_GET['category']) && $_GET['category'] === 'dob';
$s_password = isset($_GET['category']) && $_GET['category'] === 'password';
?>
  <h1>Search</h1>
  <form action="search.php" method="get">
    <label>Category:
      <select name="category">
        <option value="name" <?php print $s_name ? "selected" : ""; ?> >Name</option>
        <option value="email" <?php print $s_email ? "selected" : ""; ?> >Email</option>
        <option value="dob" <?php print $s_dob ? "selected" : ""; ?> >Date of birth</option>
        <option value="password" <?php print $s_password ? "selected" : ""; ?> >Password</option>
      </select>
    </label>
    <label>Term: <input type="text" name="term"></label>
    <input type="submit">
  </form>
<?php
require_once("functions.php");

$db = new PDO("sqlite:user.db");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['category']) && isset($_GET['term'])) {
    // SELECT the appropriate records in ascending order of user name
	$category = $_GET['category'];
	$term = $_GET['term'];
	$sql = "SELECT * FROM user WHERE ";
	// use a switch statement to sanitize info from $_GET
	switch($category) {
		case 'name';
			$sql .= "name";
			break;
		case 'email';
                        $sql .= "email";
                        break;
		case 'dob';
                        $sql .= "dob";
                        break;
		case 'password';
                        $sql .= "password";
                        break;
		default;
			$sql .= "name";
                        break;
	}
	// build remaining statement
	$sql .= " = :term ORDER BY name";

	$stmt = $db->prepare($sql);
	$stmt->execute(['term' => $term]);
	// assign matching rows to variable
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	print "<h2>Users where $category =  $term</h2>";

	//print the table
	printTable($result);
}
$db = null;
?>
  </body>
</html>
