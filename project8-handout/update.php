<!DOCTYPE html>
<html lang=en>
  <head>
    <title>Update Record</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php include "nav.html" ?>

   <h2>Update Password</h2>
  <form action="index.php" method="post">
    <label>New password: <input type="password" name="password" required></label>
<?php
require_once("functions.php");

$db = new PDO("sqlite:user.db");
$stmt = $db->query("SELECT * FROM user ORDER BY name");
$records = $stmt->fetchall(PDO::FETCH_ASSOC);
printFormTable($records);
$db = null;
?>
    <input type="hidden" name="operation" value="update">
    <input type="submit" value="Update">
  </form>
  </body>
</html>
