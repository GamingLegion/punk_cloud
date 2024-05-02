<?php
session_start();
include '../globalVars.php';
$data = json_decode( file_get_contents( 'php://input' ), true );

$user = $_SESSION['user'];
$season = $data[ 'season' ];
$rank = $data[ 'rank' ];

$result = mysqli_query( $connect3, "SELECT anime_name, season_rank FROM $user WHERE anime_name = '$season'" );
$record = mysqli_fetch_assoc( $result );
if ( isset( $record[ 'anime_name' ] ) ) {
   $old_rank = ( isset( $record[ 'season_rank' ] ) ) ? $record[ 'season_rank' ] : 0;
   $prev = isset( $record[ 'season_rank' ] );

   mysqli_query( $connect2, "UPDATE anime SET addedScore = addedScore - $old_rank, numOfRanks = numOfRanks - 1 WHERE rom_name = '$season'" );
   if ( $rank != "Select Score" ) {
      mysqli_query( $connect3, "UPDATE $user SET season_rank = $rank WHERE anime_name = '$season'" );
      mysqli_query( $connect2, "UPDATE anime SET addedScore = addedScore + $rank, numOfRanks = numOfRanks + 1 WHERE rom_name = '$season'" );
   } else {
      mysqli_query( $connect3, "UPDATE $user SET season_rank = NULL WHERE anime_name = '$season'" );
   }
}
?>