<!DOCTYPE html>
<html lang="en" style="background-color: #222425">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up</title>
<link rel="stylesheet" href="../css/loginPage.css">
</head>
<body>
   <img src="../images/icons/vegapunk.png" alt="Vegapunk" style="position: fixed; width: 15%; margin: 100px 0px 0px 150px">
<div class="container">
   <h2 style="color: white;">Sign Up</h2>
   <form id="signupForm" action="tools/signup.php" method="post">
      <div class="form-group">
         <label for="email" style="color: white;">Email:</label>
         <input type="text" id="email" name="email" required>
      </div>
      <div class="form-group">
         <label for="username" style="color: white;">Username:</label>
         <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
         <label for="password" style="color: white;">Password:</label>
         <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
         <button type="submit">Register</button>
      </div>
      <p id="error-msg"></p>
   </form>
   <a href="login.php">Login</a>
</div>
</body>
</html>
