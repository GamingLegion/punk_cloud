<?php
session_start();
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
$connect2 = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud_users' );

$email = $_POST[ 'email' ];
$username = $_POST[ 'username' ];
$password = $_POST[ 'password' ];

$result = mysqli_query( $connect, 'Select username, email FROM users' );

$check = true;
if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) {
   $check = false;
}
while ( $record = mysqli_fetch_assoc( $result ) ) {
   if ( $username === $record[ 'email' ] ) {
      $check = false;
   } else if ( $username === $record[ 'username' ] ) {
      $check = false;
   }
}
if ( $check ) {
   $_SESSION[ 'user' ] = $username;
   
   date_default_timezone_set( 'America/New_York' );
   $ins_date = date( "Y-m-d H:i:s" );
   mysqli_query( $connect, "INSERT INTO users(id, ins_date, username, email, password) VALUES ('NULL', '$ins_date', '$username', '$email', '$password');" );
   mysqli_query( $connect, "UPDATE users SET icon = 'default.png' WHERE username = '$username'" );
   
   $sql = "CREATE TABLE $username (
    id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ins_date DATETIME,
    epi_num SMALLINT(8) UNSIGNED,
    anime_name VARCHAR(255),
    anime_season VARCHAR(255),
    season_rank TINYINT(2) UNSIGNED,
    watched SMALLINT(4) UNSIGNED DEFAULT 1
    )";
   mysqli_query($connect2, $sql);
   header( "Location: http://localhost/PunkCloud/php/pages/home.php" );
} else {
   header( "Location: http://localhost/PunkCloud/php/pages/signup.php" );
}
mysqli_close( $connect );
mysqli_close( $connect2 );
?>