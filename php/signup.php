<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up</title>
<link rel="stylesheet" href="../css/login.css">
</head>
<body>
   <img src="../images/icons/vegapunk.png" alt="Vegapunk" style="position: fixed; width: 15%; margin: 100px 0px 0px 150px">
<div class="container">
   <h2>Sign Up</h2>
   <form id="signupForm" action="tools/signup.php" method="post">
      <div class="form-group">
         <label for="email">Email:</label>
         <input type="text" id="email" name="email" required>
      </div>
      <div class="form-group">
         <label for="username">Username:</label>
         <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
         <label for="password">Password:</label>
         <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
         <button type="submit">Register</button>
      </div>
      <p id="error-msg"></p>
   </form>
   <a href="login.php">Login</a>
</div>
<script src="../js/signup.js"></script>
</body>
</html>
