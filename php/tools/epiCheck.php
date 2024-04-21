<?php
session_start();
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud_users' );
$connect2 = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
$data = json_decode( file_get_contents( 'php://input' ), true );

date_default_timezone_set( 'America/New_York' );
$ins_date = date( "Y-m-d H:i:s" );
$user = $data[ 'user' ];
$i = $data[ 'epi_num' ];
$rom_name = $data[ 'rom_name' ];
$season = $data[ 'season' ];

$result = mysqli_query( $connect, "SELECT id FROM $user WHERE epi_num = $i AND anime_name = '$rom_name' AND anime_season = '$season'" );
$record = mysqli_fetch_assoc( $result );
if ( is_null( $record ) || $record[ 'id' ] === 0 ) {
   $result2 = mysqli_query( $connect, "SELECT id FROM $user WHERE anime_name = '$rom_name'" );
   if(mysqli_num_rows($result2) == 0) {
      $result3 = mysqli_query( $connect2, "SELECT addedWatch FROM anime_shows WHERE rom_name = '$rom_name'" );
      $record3 = mysqli_fetch_assoc( $result3 );
      $num = (( isset( $record3[ 'addedWatch' ] ) ) ? $record3[ 'addedWatch' ] : 0) + 1;
      mysqli_query( $connect2, "UPDATE anime_shows SET addedWatch = $num WHERE rom_name = '$rom_name'" );
   }
   mysqli_query( $connect, "INSERT INTO $user(id, ins_date, epi_num, anime_name, anime_season) VALUES('NULL', '$ins_date', '$i', '$rom_name', '$season');" );
} else if ( $record[ 'id' ] > 0 ) {
   $old_rank = mysqli_fetch_assoc(mysqli_query( $connect, "SELECT season_rank FROM $user WHERE anime_name = '$rom_name'" ))['season_rank'];
   mysqli_query( $connect, "DELETE FROM $user WHERE id = " . $record[ 'id' ] );
   $result2 = mysqli_query( $connect, "SELECT id FROM $user WHERE anime_name = '$rom_name'" );
   if(mysqli_num_rows($result2) == 0) {
      $res = mysqli_query( $connect2, "SELECT addedScore, numOfRanks, addedWatch FROM anime_shows WHERE rom_name = '$rom_name'" );
      $rec = mysqli_fetch_assoc( $res );
      $score = (( isset( $rec[ 'addedScore' ] ) ) ? $rec[ 'addedScore' ] - $old_rank : 0);
      $numoranks = (( isset( $rec[ 'numOfRanks' ] ) ) ? $rec[ 'numOfRanks' ] - 1 : 0);
      $watch = (( isset( $rec[ 'addedWatch' ] ) ) ? $rec[ 'addedWatch' ] - 1 : 0);
      mysqli_query( $connect2, "UPDATE anime_shows SET addedScore = $score, numOfRanks = $numoranks, addedWatch = $watch WHERE rom_name = '$rom_name'" );
   }
}

$result2 = mysqli_query( $connect2, "SELECT id FROM $user WHERE epi_num = $i AND anime_name = '$rom_name' AND anime_season = '$season'" );

mysqli_close( $connect );
mysqli_close( $connect2 );
?>