<?php
$data = json_decode( file_get_contents( 'php://input' ), true );
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );

date_default_timezone_set( 'America/New_York' );
$upd_date = date( "Y-m-d H:i:s" );
$name = $data[ 'name' ];
$season = $data[ 'season' ];
$field = $data[ 'field' ];
$value = $data[ 'value' ];

if ( $field == 'start_date' || $field == 'end_date' ) {
   $value = date( "Y-m-d", strtotime( $value ) );;
}

mysqli_query( $connect, "UPDATE anime_shows SET $field = '$value', upd_date = '$upd_date' WHERE rom_name = '$name' AND season = '$season'" );
mysqli_close( $connect );
?>