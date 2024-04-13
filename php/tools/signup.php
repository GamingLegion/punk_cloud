<?php
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud_users' );

$email = $_POST[ 'email' ];
$username = $_POST[ 'username' ];
$password = $_POST[ 'password' ];

$result = mysqli_query( $connect, 'Select username, email FROM userlist' );

$check = true;
if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) {
   echo "invalMail";
   $check = false;
}
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
   mysqli_query( $connect, "INSERT INTO userlist(id, username, email, password) VALUES ('NULL', '$username', '$email', '$password');" );
}

?>