<?php
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );

$email = $_POST[ 'email' ];
$username = $_POST[ 'username' ];
$password = $_POST[ 'password' ];

$result = mysqli_query( $connect, 'Select username, email FROM users' );

// Check if the submitted username and password match the valid credentials

while ( $record = mysqli_fetch_assoc( $result ) ) {
   if ($username === $record[ 'email' ]) {
      echo "mailFail";
   } else if ($username === $record[ 'username' ]) {
      echo "userFail";
   }
}

?>