<?php
session_start();
include '../globalVars.php';
$data = json_decode( file_get_contents( 'php://input' ), true );

$user = $_SESSION[ 'user' ];
$incdec = $data[ 'incdec' ];
$i = $data[ 'epi_num' ];
$rom_name = $data[ 'rom_name' ];
$season = $data[ 'season' ];

$result = mysqli_query( $connect3, "SELECT id, season_rank, watched FROM $user WHERE epi_num = $i AND anime_name = '$rom_name' AND anime_season = '$season'" );
if ( mysqli_num_rows( $result ) > 0 ) {
   $record = mysqli_fetch_assoc( $result );
   if ( $incdec == 0 ) {
      mysqli_query( $connect3, "UPDATE $user SET watched = watched + 1 WHERE id = " . $record[ 'id' ] );
   } else if ( $incdec == 1 ) {
      if ( $record[ 'watched' ] > 1 ) {
         mysqli_query( $connect3, "UPDATE $user SET watched = watched - 1 WHERE id = " . $record[ 'id' ] );
      } else {
         mysqli_query( $connect3, "DELETE FROM $user WHERE id = " . $record[ 'id' ] );
         $result2 = mysqli_query( $connect3, "SELECT id FROM $user WHERE epi_num = $i AND anime_name = '$rom_name' AND anime_season = '$season'" );
         if ( mysqli_num_rows( $result2 ) < 1 ) {
            mysqli_query( $connect1, "UPDATE anime SET addedScore = addedScore - ".$record[ 'season_rank' ].", numOfRanks = numOfRanks - 1, addedWatch = addedWatch - 1 WHERE rom_name = '$rom_name' AND season = '$season'" );
         }
      }
   }
}
?>