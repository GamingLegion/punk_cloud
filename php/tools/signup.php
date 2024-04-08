<?php
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );

$email = $_POST[ 'email' ];
$username = $_POST[ 'username' ];
$password = $_POST[ 'password' ];

$result = mysqli_query( $connect, 'Select username, email FROM users' );

$check = true;
while ( $record = mysqli_fetch_assoc( $result ) ) {
   if ( $username === $record[ 'email' ] ) {
      echo "mailFail";
      $check = false;
   } else if ( $username === $record[ 'username' ] ) {
      echo "userFail";
      $check = false;
   }
}
if ( $check ) {
   mysqli_query( $connect, "INSERT INTO users(id, username, email, password) VALUES ('NULL', '$username', '$email', '$password');" );
}

?>