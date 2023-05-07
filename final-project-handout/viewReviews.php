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
if (!$_SESSION) {
	include "signedOutNav.html";
}
if ($_SESSION) {
	include "signedInNav.html";	
	$db = new PDO("sqlite:review.db");
	$locationID = -1;
	$locationName = "";

	if (isset($_POST["locationID"])) {
			$locationID = $_POST["locationID"];
			$locationName = $_POST["name"];
			$currentDate = date("Y-M-d");

			$sql = "INSERT INTO tbReview VALUES (NULL, ?, ?, ?, ?, ?)";
	
			$stmt = $db->prepare($sql);
			$stmt->execute([$locationID, $_SESSION["userID"], $_POST["Rating"], $currentDate, $_POST["Comments"]]);
			$records = $stmt->fetchall(PDO::FETCH_ASSOC);
	}
	elseif (isset($_GET["location"])) {
			$locationID = $_GET["location"];
			$locationName = $_GET["name"];
	}

	print("<h2>Reviews for " . $locationName . "</h2>");

	$sql = "SELECT 
		A.reviewID,
		B.username as 'User Name', 
		A.userScore as 'Rating',
		A.comments as 'Comments',
		A.reviewDate as 'Review Date'
	FROM 
		tbReview A 
	INNER JOIN tbUser B ON 
		A.userID = B.userID WHERE A.userID = $_SESSION[userID] AND A.locationID = ?";

	$stmt = $db->prepare($sql);
	$stmt->execute([$locationID]);
	$records = $stmt->fetchall(PDO::FETCH_ASSOC);
	printTable($records);
	
}

?>
	<br/>
	<h3>Write a Review</h3>
	<form action="viewReviews.php" method="post">
	<select name="Rating">
		<option value="1">1 star</option>
		<option value="2">2 stars</option>
		<option value="3">3 stars</option>
		<option value="4">4 stars</option>
		<option value="5">5 stars</option>
	</select>
	<input type="text" name="Comments" placeholder="Comments"><br/>
	<input type="hidden" name="locationID" value="<?php echo $locationID ?>">
	<input type="hidden" name="name" value="<?php echo $locationName ?>">
	<input type="submit" name="Submit">
	</form>
  </body>
</html>
