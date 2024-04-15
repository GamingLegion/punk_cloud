<?php
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );

$email = $_POST[ 'email' ];
$username = $_POST[ 'username' ];
$password = $_POST[ 'password' ];

$result = mysqli_query( $connect, 'Select username, email FROM user' );

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
   date_default_timezone_set( 'America/New_York' );
   $ins_date = date( "Y-m-d H:i:s" );
   mysqli_query( $connect, "INSERT INTO user(id, ins_date, username, email, password) VALUES ('NULL', '$ins_date', $username', '$email', '$password');" );
}

?>