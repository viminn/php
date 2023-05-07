<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

<?php
session_start();

require_once("functions.php");

if ($_SESSION) {
	include "signedInNav.html";
	print("<h1>Welcome $_SESSION[username]</h1>");
}
else {
	include "signedOutNav.html";
	print("<h1>Welcome, please sign in to write a review</h1>");
}


$db = new PDO("sqlite:review.db");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM tbReview LIMIT 3";
$stmt = $db->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

print_r("<h2>Review Highlights</h2>");

printTable($result);

?>

</body>
