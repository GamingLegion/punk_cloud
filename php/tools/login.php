<?php
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );

$username = $_POST[ 'username' ];
$password = $_POST[ 'password' ];

$result = mysqli_query( $connect, 'Select username, email, password FROM users' );

$check = true;
while ( $record = mysqli_fetch_assoc( $result ) ) {
   if ( ( $username === $record[ 'username' ] || $username === $record[ 'email' ] ) && $password === $record[ 'password' ] ) {
      echo "success";
      $check = false;
   }
}
if ( $check ) {
   echo "fail";
}

?>