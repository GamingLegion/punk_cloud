<?php
session_start();
include '../globalVars.php';
$data = json_decode( file_get_contents( 'php://input' ), true );
date_default_timezone_set( 'America/New_York' );

$ins_date = date( "Y-m-d H:i:s" );
$user = $_SESSION[ 'user' ];
$name = $data[ 'name' ];
$season = $data[ 'season' ];
$status = ( $data[ 'status' ] != "Select Status" ) ? $data[ 'status' ] : NULL;

$result = mysqli_query( $connect3, "SELECT status FROM $user WHERE epi_num = 0 anime_name = '$name' AND anime_season = '$season'" );
if ( mysqli_num_rows( $result ) > 0 ) {
   $record = mysqli_fetch_assoc( $result );
} else if( $status != NULL) {
   mysqli_query( $connect3, "INSERT INTO $user(id, ins_date, epi_num, anime_name, anime_season, status) VALUES('NULL', '$ins_date', '0', '$name', '$season', '$status')" );
}


$query = "UPDATE $user SET status = ? WHERE anime_name = ? AND anime_season = ?";
$stmt = mysqli_prepare( $connect3, $query );
mysqli_stmt_bind_param( $stmt, "iss", $rank, $name, $season );
mysqli_stmt_execute( $stmt );
mysqli_stmt_close( $stmt );

if ( $rank != NULL ) {
   mysqli_query( $connect1, "UPDATE anime SET addedScore = addedScore + $rank, numOfRanks = numOfRanks + 1 WHERE rom_name = '$name' AND season = '$season'" );
}
?>