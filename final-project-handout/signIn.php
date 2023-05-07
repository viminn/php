<?php

require_once("functions.php");

$failedLogin = False;

if (isset($_POST['username']) && isset($_POST['password'])) {
        $result = getUserRecord($_POST['username'], $_POST['password']);
        if ($result) {
                session_start();
                $_SESSION += $result;
                header("Location: index.php");
                exit();
        }
        else {
                $failedLogin = True;
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include "signedOutNav.html" ?>

  <h1>Sign In</h1>
  
  <?php
  if ($failedLogin) {
          print("<h2>Error: Invalid login information</h2>");
  }
  ?>
  
  <form action="signIn.php" method="post">
      <label>Username <input type="text" name="username" required autofocus></label>
      <br>
      <label>Password <input type="password" name="password" required></label>
      <br>
      <input type="submit" value="Sign In">
  </form>
</body>
</html>
