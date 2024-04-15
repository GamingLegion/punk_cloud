<?php
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
$result = mysqli_query( $connect, 'SELECT username, email, password FROM users' );

$username = $_POST[ 'username' ];
$password = $_POST[ 'password' ];

while ( $record = mysqli_fetch_assoc( $result ) ) {
   if ( ( $username === $record[ 'username' ] || $username === $record[ 'email' ] ) && $password === $record[ 'password' ] ) {
      $_SESSION[ 'user' ] = $record[ 'username' ];
      echo $_SESSION[ 'user' ];
   }
}

mysqli_close( $connect );
//header( "Location: http://localhost/PunkCloud/php/home.php" );
?>