<!DOCTYPE html>
<html lang=en>
  <head>
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php include "nav.html" ?>
    <h1>List of Users</h1>
<?php
require_once("functions.php");

// open a database connection
$db = new PDO("sqlite:user.db");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['operation'])) {
    $operation = $_POST['operation'];

    // INSERT
    if ($operation === 'create'
        && isset($_POST['name'])
        && isset($_POST['email'])
        && isset($_POST['dob'])
        && isset($_POST['password'])
    ){
	// INSERT
	$sql = "INSERT INTO user (name, email, dob, password) VALUES (:name, :email, :dob, :password)";
	$stmt = $db->prepare($sql);
	$stmt->execute([
	  'name' => $_POST['name'],
	  'email' => $_POST['email'],
	  'dob' => $_POST['dob'],
	  'password' => $_POST['password']]);

    }
    // UPDATE
    else if ($operation === 'update'
        && isset($_POST['password'])
        && isset($_POST['rows'])
    ){
	$rowsArray = $_POST['rows'];
	$sql = "UPDATE user SET password=:newPass WHERE email=:userEmail";
	$stmt = $db->prepare($sql);
	foreach ($rowsArray as $row){
		$valuesArray = explode(',', $row);
		$xEmail = $valuesArray[1];

		$stmt->execute([
		  'newPass' => $_POST['password'],
		  'userEmail' => $xEmail]);
	}
    }
    // DELETE
    else if ($operation === 'delete' && isset($_POST['rows'])){
	$rowsArray = $_POST['rows'];
	$sql = "DELETE FROM user WHERE email=:userEmail";
	$stmt = $db->prepare($sql); 
	foreach ($rowsArray as $row){
		$valuesArray = explode(',', $row);
		$xEmail = $valuesArray[1];
		$stmt->execute([
		  'userEmail' => $xEmail]);
	}
    }
}

$stmt = $db->query("select * from user order by name");
$records = $stmt->fetchall(PDO::FETCH_ASSOC);
printTable($records);
$db = null;
?>

  </body>
</html>
