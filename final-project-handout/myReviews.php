<?php session_start() ?>
<!DOCTYPE html>
<html lang=en>
  <head>
    <title>My Reviews</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php include "signedInNav.html" ?>

    <h2>My Reviews</h2>
  <form action="myReviews.php" method="post">
  <label>Update
    <input type="radio" name="operation" value="update">
  </label>
  <select name="field">
	<option value="rating">Rating:</option>
	<option value="comments">Comments:</option>
  </select>
  <input type="text" name="reviewEdit"></br>
  <label>Delete
    <input type="radio" name="operation" value="delete">
  </label>

<?php

require_once("functions.php");

$db = new PDO("sqlite:review.db");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['operation'])) {
	$operation = $_POST['operation'];
	if ($operation === "update") {
		$field = $_POST['field'];
		$reviewEdit = $_POST['reviewEdit'];
		$rowsArray = $_POST['rows'];

		$sql = "UPDATE tbReview SET ";
		switch ($field) {
			case 'rating';	
				$sql .= "userScore ";
				break;
			case 'comments';
				$sql .= "comments ";
				break;
			default;
				$sql .= "userScore ";
				break;
		}
		$sql .= "= :reviewEdit WHERE reviewID=:reviewID AND userID=$_SESSION[userID]";
		$stmt = $db->prepare($sql); 
		foreach ($rowsArray as $row){
			$valuesArray = explode(',', $row);
			$rowID = $valuesArray[0];
			$stmt->execute([
			  'reviewEdit' => $reviewEdit,
			  'reviewID' => $rowID]);
		}

	}
	elseif ($operation === "delete") {
		$rowsArray = $_POST['rows'];
		$sql = "DELETE FROM tbReview WHERE reviewID=:reviewID AND userID=$_SESSION[userID]";
		$stmt = $db->prepare($sql); 
		foreach ($rowsArray as $row){
			$valuesArray = explode(',', $row);
			$rowID = $valuesArray[0];
			$stmt->execute([
			  'reviewID' => $rowID]);
			}
	}
}
$db = new PDO("sqlite:review.db");
$stmt = $db->query(
	"SELECT 
		A.reviewID,
		B.locationName as 'Location Name', 
		A.userScore as 'Rating',
		A.comments as 'Comments',
		A.reviewDate as 'Review Date'
	FROM 
		tbReview A 
	INNER JOIN tbLocation B ON 
		A.locationID = B.locationID WHERE userID = $_SESSION[userID]"
	);
$records = $stmt->fetchall(PDO::FETCH_ASSOC);
printFormTable($records);
$db = null;
?>
    <input type="submit" value="Submit">
  </form>
  </body>
</html>
