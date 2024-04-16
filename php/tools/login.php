<?php
session_start();
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
$result = mysqli_query( $connect, 'SELECT username, email, password FROM users' );

$username = $_POST[ 'username' ];
$password = $_POST[ 'password' ];

$check = false;
while ( $record = mysqli_fetch_assoc( $result ) ) {
   if ( ( $username === $record[ 'username' ] || $username === $record[ 'email' ] ) && $password === $record[ 'password' ] ) {
      $_SESSION[ 'user' ] = $record[ 'username' ];
      
      header( "Location: http://localhost/PunkCloud/php/home.php" );
      $check = true;
   }
}
if(!$check) {
   header( "Location: http://localhost/PunkCloud/php/login.php" );
}
mysqli_close( $connect );
?>