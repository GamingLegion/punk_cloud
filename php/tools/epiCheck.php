<?php
session_start();
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud_users' );
$connect2 = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
$data = json_decode( file_get_contents( 'php://input' ), true );

date_default_timezone_set( 'America/New_York' );
$ins_date = date( "Y-m-d H:i:s" );
$user = $_SESSION[ 'user' ];
$epiNum = $data[ 'epi_num' ];
$romName = $data[ 'rom_name' ];
$season = $data[ 'season' ];

$result = mysqli_query( $connect, "SELECT id FROM $user WHERE epi_num = $epiNum AND anime_name = '$romName' AND anime_season = '$season'" );
$record = mysqli_fetch_assoc( $result );
if ( is_null( $record ) || $record[ 'id' ] === 0 ) {
   $result2 = mysqli_query( $connect, "SELECT id, season_rank FROM $user WHERE anime_name = '$romName'" );
   $rank = isset(mysqli_fetch_assoc( $result2 )[ 'season_rank' ]) ? mysqli_fetch_assoc( $result2 )[ 'season_rank' ] : -1;
   if ( mysqli_num_rows( $result2 ) < 1 ) {
      $result3 = mysqli_query( $connect2, "SELECT addedWatch FROM anime WHERE rom_name = '$romName'" );
      $record3 = mysqli_fetch_assoc( $result3 );
      $num = ( ( isset( $record3[ 'addedWatch' ] ) ) ? $record3[ 'addedWatch' ] : 0 ) + 1;
      mysqli_query( $connect2, "UPDATE anime SET addedWatch = $num WHERE rom_name = '$romName'" );
      mysqli_query( $connect, "INSERT INTO $user(id, ins_date, epi_num, anime_name, anime_season) VALUES('NULL', '$ins_date', '$epiNum', '$romName', '$season');" );
   } else {
      mysqli_query( $connect, "INSERT INTO $user(id, ins_date, epi_num, anime_name, anime_season) VALUES('NULL', '$ins_date', '$epiNum', '$romName', '$season');" );
   }
   $r = mysqli_query($conn, "SELECT MAX(id) AS max_id FROM your_table");
   $maxId = mysqli_fetch_assoc($r['max_id']);
   mysqli_query($connect, "UPDATE $user SET season_rank = $rank WHERE id = $maxId");
} else {
   $old_rank = mysqli_fetch_assoc( mysqli_query( $connect, "SELECT season_rank FROM $user WHERE anime_name = '$romName'" ) )[ 'season_rank' ];
   mysqli_query( $connect, "DELETE FROM $user WHERE id = " . $record[ 'id' ] );
   $result2 = mysqli_query( $connect, "SELECT id FROM $user WHERE anime_name = '$romName'" );
   if ( mysqli_num_rows( $result2 ) == 0 ) {
      $res = mysqli_query( $connect2, "SELECT addedScore, numOfRanks, addedWatch FROM anime WHERE rom_name = '$romName'" );
      $rec = mysqli_fetch_assoc( $res );
      $score = ( ( isset( $rec[ 'addedScore' ] ) ) ? $rec[ 'addedScore' ] - $old_rank : 0 );
      $numoranks = ( ( isset( $rec[ 'numOfRanks' ] ) ) ? (isset($old_rank) ? $rec[ 'numOfRanks' ] - 1 : $rec[ 'numOfRanks' ]) : 0 );
      $watch = ( ( isset( $rec[ 'addedWatch' ] ) ) ? $rec[ 'addedWatch' ] - 1 : 0 );
      mysqli_query( $connect2, "UPDATE anime SET addedScore = $score, numOfRanks = $numoranks, addedWatch = $watch WHERE rom_name = '$romName'" );
   }
}

$result2 = mysqli_query( $connect2, "SELECT id FROM $user WHERE epi_num = $epiNum AND anime_name = '$romName' AND anime_season = '$season'" );

mysqli_close( $connect );
mysqli_close( $connect2 );
?>