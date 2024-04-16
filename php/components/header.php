<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Header Bar</title>
<link rel="stylesheet" type="text/css" href="../css/header.css">

<div class="headerBar">
   <div class="searchCats"> <a href="home.php"><img src="../images/icons/logo.png" alt="PunkCloud Logo" class="homeBtn"></a> </div>
   <div class="searchBar"> </div>
   <div class="userOpts"> 
      <?php
      $connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
      
      if ( isset( $_SESSION[ 'user' ] ) ) {
         if($_SESSION[ 'user' ] === 'oracle') {
            echo '<a href="addEntry.php"><img src="../images/icons/addEntry_icon.png" alt="PunkCloud Logo" class="addEntryBtn"></a>';
         }
      
         $result = mysqli_query( $connect, "Select icon FROM users WHERE username = '" . $_SESSION[ 'user' ] . "' " );
         $record = mysqli_fetch_assoc( $result );
         echo '<a href="userPage.php"><img src="../images/users/' . $record[ 'icon' ] . '" alt="User" class="loginBtn"></a>';
      } else {
         echo '<a href="login.php"><img src="../images/icons/login_icon.png" alt="Login" class="loginBtn"></a>';
      }
      ?>
   </div>
</div>
</head>
</html>
