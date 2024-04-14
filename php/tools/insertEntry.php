<?php
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );

if ( isset( $_POST[ 'submit' ] ) ) {
	$ins_date = date("Y-m-d H:i:s");
  $eng_name = $_POST[ 'eng_name' ];
  $rom_name = $_POST[ 'rom_name' ];
  $image = $_POST[ 'image' ];

  $eng_name = str_replace( "'", "\'", $eng_name );
  $eng_name = str_replace( "\"", "\"", $eng_name );
  $rom_name = str_replace( "'", "\'", $rom_name );
  $rom_name = str_replace( "\"", "\"", $rom_name );

  mysqli_query( $connect, "INSERT INTO anime_shows(id, ins_date, upd_date, eng_name, rom_name, image)
	VALUES ('NULL', '$ins_date', '$ins_date', '$eng_name', '$rom_name', '$image');");
   mysqli_close( $connect );
   header( "Location: http://localhost/PunkCloud/php/home.php" );
}
?>