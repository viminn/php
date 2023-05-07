<!DOCTYPE html>
<html lang=en>
  <head>
    <title>Create Record</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
<?php include "nav.html" ?>
  <h1>Create Record</h1>
  <form action="index.php" method="post">
    <label class="block">Name: <input type="text" name="name" required></label>
    <label class="block">Email: <input type="email" name="email" required></label>
    <label class="block">Date of birth: <input type="date" name="dob" required></label>
    <label class="block">Password: <input type="password" name="password" required></label>
    <input type="hidden" name="operation" value="create">
    <input type="submit" value="Create">
  </form>
  </body>
</html>
