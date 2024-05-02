<?php
session_start();
include '../globalVars.php';
$data = json_decode( file_get_contents( 'php://input' ), true );

$user = $_SESSION[ 'user' ];
$name = $data[ 'name' ];
$season = $data[ 'season' ];
$rank = ( $data[ 'rank' ] != "Select Score" ) ? $data[ 'rank' ] : NULL;

$result = mysqli_query( $connect3, "SELECT season_rank FROM $user WHERE anime_name = '$name' AND anime_season = '$season'" );
$record = mysqli_fetch_assoc( $result );
if ( isset( $record[ 'season_rank' ] ) ) {
   mysqli_query( $connect1, "UPDATE anime SET addedScore = addedScore - " . $record[ 'season_rank' ] . ", numOfRanks = numOfRanks - 1 WHERE rom_name = '$name' AND season = '$season'" );
}

$query = "UPDATE $user SET season_rank = ? WHERE anime_name = ? AND anime_season = ?";
$stmt = mysqli_prepare($connect3, $query);
mysqli_stmt_bind_param($stmt, "iss", $rank, $name, $season);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ( $rank != NULL ) {
   mysqli_query( $connect1, "UPDATE anime SET addedScore = addedScore + $rank, numOfRanks = numOfRanks + 1 WHERE rom_name = '$name' AND season = '$season'" );
}
?>