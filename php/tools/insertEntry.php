<?php
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );

if ( isset( $_POST[ 'submit' ] ) ) {
	$ins_date = date("Y-m-d H:i:s");
  $eng_name = $_POST[ 'eng_name' ];
  $rom_name = $_POST[ 'rom_name' ];
  $image = $_POST[ 'image' ];
  $status = strtolower( $_POST[ 'status' ] );
  $epi_num = $_POST[ 'epi_num' ];
  $start_date = $_POST[ 'start_date' ];
  $end_date = $_POST[ 'end_date' ];
  $air_season = $_POST[ 'air_season' ];
  $demographic = $_POST[ 'demographic' ];

  $eng_name = str_replace( "'", "\'", $eng_name );
  $eng_name = str_replace( "\"", "\"", $eng_name );
  $rom_name = str_replace( "'", "\'", $rom_name );
  $rom_name = str_replace( "\"", "\"", $rom_name );

  mysqli_query( $connect, "INSERT INTO anime_shows(id, ins_date, upd_date, eng_name, rom_name, image, status, epi_num, start_date, end_date, air_season, demographic)
	VALUES ('NULL', '$ins_date', '$ins_date', '$eng_name', '$rom_name', '$image', '$status', '$epi_num', '$start_date', '$end_date', '$air_season', '$demographic');");
  if ( $start_date === "0000-00-00" ) {
    mysqli_query( $connect, "UPDATE anime_shows SET start_date = NULL WHERE eng_name = '$eng_name';");
  }
  if ( $end_date === "0000-00-00" ) {
    mysqli_query( $connect, "UPDATE anime_shows SET end_date = NULL WHERE eng_name = '$eng_name';");
  }
}
?>