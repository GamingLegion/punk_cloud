<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="../css/loginPage.css">
</head>
<body>
   <img src="../images/icons/vegapunk.png" alt="Vegapunk" style="position: fixed; width: 15%; margin: 100px 0px 0px 150px">
<div class="container">
   <h2>Login</h2>
   <form id="loginForm" action="tools/login.php" method="post">
      <div class="form-group">
         <label for="username">User/Email:</label>
         <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
         <label for="password">Password:</label>
         <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
         <button type="submit">Login</button>
      </div>
      <p id="error-msg"></p>
   </form>
   <a href="signup.php">Sign Up</a>
</div>
<script src="../js/login.js"></script>
</body>
</html>
