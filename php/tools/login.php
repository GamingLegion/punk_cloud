<?php
session_start();
include '../globalVars.php';

$username = $_POST[ 'username' ];
$password = $_POST[ 'password' ];

$check = false;
$result = mysqli_query( $connect1, 'SELECT username, email, password FROM users' );
while ( $record = mysqli_fetch_assoc( $result ) ) {
   if ( ( $username === $record[ 'username' ] || $username === $record[ 'email' ] ) && $password === $record[ 'password' ] ) {
      $_SESSION[ 'user' ] = $record[ 'username' ];
      
      header( "Location: http://localhost/PunkCloud/php/pages/home.php" );
      $check = true;
   }
}
if(!$check) {
   header( "Location: http://localhost/PunkCloud/php/pages/login.php" );
}
?>