<?php
session_start();
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud_users' );
$data = json_decode( file_get_contents( 'php://input' ), true );

date_default_timezone_set( 'America/New_York' );
$ins_date = date( "Y-m-d H:i:s" );
$user = $_SESSION['user'];
$i = $data[ 'epi_num' ];
$rom_name = $data[ 'rom_name' ];
$season = $data[ 'season' ];

$result = mysqli_query( $connect, "SELECT id FROM $user WHERE epi_num = $i AND anime_name = '$rom_name' AND anime_season = '$season'" );
$record = mysqli_fetch_assoc( $result );
if ( is_null( $record ) || $record[ 'id' ] === 0 ) {
   mysqli_query( $connect, "INSERT INTO $user(id, ins_date, epi_num, anime_name, anime_season) VALUES('NULL', '$ins_date', '$i', '$rom_name', '$season');" );
} else if ( $record[ 'id' ] > 0 ) {
   mysqli_query( $connect, "DELETE FROM $user WHERE id = " . $record[ 'id' ] );
}
mysqli_close( $connect );
?>