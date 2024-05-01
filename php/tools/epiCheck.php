<?php
session_start();
include '../globalVars.php';
$data = json_decode( file_get_contents( 'php://input' ), true );

date_default_timezone_set( 'America/New_York' );
$ins_date = date( "Y-m-d H:i:s" );
$user = $_SESSION[ 'user' ];
$epiNum = $data[ 'epi_num' ];
$romName = mysqli_real_escape_string( $connect3, $data[ 'rom_name' ] );
$season = mysqli_real_escape_string( $connect3, $data[ 'season' ] );

$result = mysqli_query( $connect3, "SELECT id FROM $user WHERE epi_num = $epiNum AND anime_name = '$romName' AND anime_season = '$season'" );
$record = mysqli_fetch_assoc( $result );

if ( is_null( $record ) || $record[ 'id' ] === 0 ) {
   $result2 = mysqli_query( $connect3, "SELECT epi_num, season_rank FROM $user WHERE anime_name = '$romName' AND anime_season = '$season' ORDER BY epi_num" );
   $record2 = mysqli_fetch_assoc( $result2 );
   $rank = isset( $record2[ 'season_rank' ] ) ? $record2[ 'season_rank' ] : NULL;
   if ( mysqli_num_rows( $result2 ) < 1 ) {
      $result3 = mysqli_query( $connect1, "SELECT addedWatch FROM anime WHERE rom_name = '$romName'" );
      $record3 = mysqli_fetch_assoc( $result3 );
      $num = ( ( isset( $record3[ 'addedWatch' ] ) ) ? $record3[ 'addedWatch' ] : 0 ) + 1;
      mysqli_query( $connect1, "UPDATE anime SET addedWatch = $num WHERE rom_name = '$romName'" );
   }
   mysqli_query( $connect3, "INSERT INTO $user(id, ins_date, epi_num, anime_name, anime_season) VALUES('NULL', '$ins_date', '$epiNum', '$romName', '$season');" );
   $r = mysqli_query( $connect3, "SELECT MAX(id) AS max_id FROM $user" );
   $maxId = mysqli_fetch_assoc( $r )[ 'max_id' ];
   mysqli_query( $connect3, "UPDATE $user SET season_rank = $rank WHERE id = $maxId" );
} else {
   $old_rank = mysqli_fetch_assoc( mysqli_query( $connect3, "SELECT season_rank FROM $user WHERE anime_name = '$romName'" ) )[ 'season_rank' ];
   mysqli_query( $connect3, "DELETE FROM $user WHERE id = " . $record[ 'id' ] );
   $result2 = mysqli_query( $connect3, "SELECT id FROM $user WHERE anime_name = '$romName'" );
   if ( mysqli_num_rows( $result2 ) == 0 ) {
      $res = mysqli_query( $connect1, "SELECT addedScore, numOfRanks, addedWatch FROM anime WHERE rom_name = '$romName'" );
      $rec = mysqli_fetch_assoc( $res );
      $score = ( ( isset( $rec[ 'addedScore' ] ) ) ? $rec[ 'addedScore' ] - $old_rank : 0 );
      $numoranks = ( ( isset( $rec[ 'numOfRanks' ] ) ) ? ( isset( $old_rank ) ? $rec[ 'numOfRanks' ] - 1 : $rec[ 'numOfRanks' ] ) : 0 );
      $watch = ( ( isset( $rec[ 'addedWatch' ] ) ) ? $rec[ 'addedWatch' ] - 1 : 0 );
      mysqli_query( $connect1, "UPDATE anime SET addedScore = $score, numOfRanks = $numoranks, addedWatch = $watch WHERE rom_name = '$romName'" );
   }
}
?>