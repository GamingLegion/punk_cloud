<?php
session_start();
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud_users' );
$connect2 = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
$data = json_decode( file_get_contents( 'php://input' ), true );

$user = $data[ 'user' ];
$season = $data[ 'season' ];
$rank = $data[ 'rank' ];

$result = mysqli_query( $connect, "SELECT anime_name, season_rank FROM $user WHERE anime_name = '$season'" );
$record = mysqli_fetch_assoc( $result );
if ( isset( $record[ 'anime_name' ] ) ) {
   $old_rank = ( isset( $record[ 'season_rank' ] ) ) ? $record[ 'season_rank' ] : 0;
   $prev = isset( $record[ 'season_rank' ] );

   if ( $rank != "Select Score" ) {
      mysqli_query( $connect, "UPDATE $user SET season_rank = $rank WHERE anime_name = '$season'" );
   } else {
      mysqli_query( $connect, "UPDATE $user SET season_rank = NULL WHERE anime_name = '$season'" );
   }

   $result2 = mysqli_query( $connect2, "SELECT addedScore, numOfRanks FROM anime_shows WHERE rom_name = '$season'" );
   $record2 = mysqli_fetch_assoc( $result2 );
   $score = ( isset( $record2[ 'addedScore' ] ) ) ? $record2[ 'addedScore' ] : 0;
   $score -= $old_rank;
   $num = ( isset( $record2[ 'numOfRanks' ] ) ) ? $record2[ 'numOfRanks' ] : 0;
   if ( $prev ) {
      $num--;
   }

   if ( $rank != "Select Score" ) {
      $score += $rank;
      $num++;
   }

   mysqli_query( $connect2, "UPDATE anime_shows SET addedScore = $score, numOfRanks = $num WHERE rom_name = '$season'" );
}

mysqli_close( $connect );
mysqli_close( $connect2 );
?>