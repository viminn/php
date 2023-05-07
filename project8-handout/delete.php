<!DOCTYPE html>
<html lang=en>
  <head>
    <title>Delete Record</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php include "nav.html" ?>

   <h2>Delete Record</h2> 
  <form action="index.php" method="post">
<?php
require_once("functions.php");

$db = new PDO("sqlite:user.db");
$stmt = $db->query("SELECT * FROM user ORDER BY name");
$records = $stmt->fetchall(PDO::FETCH_ASSOC);
printFormTable($records);
$db = null;
?>
    <input type="hidden" name="operation" value="delete">
    <input type="submit" value="Delete">
  </form>
  </body>
</html>
