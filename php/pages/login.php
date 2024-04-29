<!DOCTYPE html>
<html lang="en" style="background-color: #222425">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<?php
session_start();
include '../globalVars.php';

echo '<link rel="stylesheet" type="text/css" href="' . $css . 'loginPage.css">';
include( $header );
?>
</head>
<body>
<?php
echo '<img src="' . $icons . 'vegapunk.png" alt="Vegapunk" style="position: fixed; width: 15%; margin: 100px 0px 0px 150px">';
?>
<div class="container">
   <h2 style="color: white;">Login</h2>
   <?php
   echo '<form id="loginForm" action="' . $tools . 'login.php" method="post">';
   ?>
   <div class="form-group">
      <label for="username" style="color: white;">User/Email:</label>
      <input type="text" id="username" name="username" required>
   </div>
   <div class="form-group">
      <label for="password" style="color: white;">Password:</label>
      <input type="password" id="password" name="password" required>
   </div>
   <div class="form-group">
      <button type="submit">Login</button>
   </div>
   <p id="error-msg"></p>
   </form>
   <?php
   echo '<a href="' . $pages . 'signup.php">Sign Up</a> </div>';
   ?>
</div>
</body>
</html>
