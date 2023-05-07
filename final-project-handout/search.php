<!DOCTYPE html>
<html lang=en>
  <head>
    <title>Search</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>

<?php
session_start();

require_once("functions.php");

if ($_SESSION) {
	include "signedInNav.html";
}
else {
	include "signedOutNav.html";
}

$s_name = isset($_GET['category']) && $_GET['category'] === 'locationName';
$s_address = isset($_GET['category']) && $_GET['category'] === 'locationAddress';

?>
  <h1>Search</h1>
  <form action="search.php" method="get">
    <label>Category:
      <select name="category">
        <option value="locationName" <?php print $s_name ? "selected" : ""; ?> >Name</option>
        <option value="locationAddress" <?php print $s_address ? "selected" : ""; ?> >Address</option>
      </select>
    </label>
    <label>Term: <input type="text" name="term"></label>
    <input type="submit">
  </form>

<?php
require_once("functions.php");

$db = new PDO("sqlite:review.db");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//search for locations
if (isset($_GET['category']) && isset($_GET['term'])) {
    // SELECT the appropriate records in ascending order of user name
	$category = $_GET['category'];
	$term = $_GET['term'];
	$sql = "SELECT locationID, locationName as 'Location Name', address as 'Address',
	       city as 'City', state as 'State', zipCode as 'Zip Code' FROM tbLocation WHERE ";
	// use a switch statement to sanitize info from $_GET
	switch($category) {
		case 'locationName';
			$sql .= "locationName";
			break;
		case 'locationAddress';
                        $sql .= "address";
                        break;
		default;
			$sql .= "locationName";
                        break;
	}
	// build remaining statement
	$sql .= " = :term";

	$stmt = $db->prepare($sql);
	$stmt->execute(['term' => $term]);
	// assign matching rows to variable
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if ($result) {
		print "<h2>Locations where $category = $term</h2>";

		//print the table
		printReviewTable($result);
	}
	else {
		$sql = "SELECT locationID, locationName as 'Location Name', address as 'Address',
			city as 'City', state as 'State', zipCode as 'Zip Code' FROM tbLocation LIMIT 10";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		print_r("<h2>No results found, top locations:</h2>");

		printReviewTable($result);

	}
}

$db = null;
?>
  </body>
</html>
