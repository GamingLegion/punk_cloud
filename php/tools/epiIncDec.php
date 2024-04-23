<?php
session_start();
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud_users' );
$connect2 = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
$data = json_decode( file_get_contents( 'php://input' ), true );

$user = $_SESSION[ 'user' ];
$incdec = $data[ 'incdec' ];
$i = $data[ 'epi_num' ];
$rom_name = $data[ 'rom_name' ];
$season = $data[ 'season' ];

$result = mysqli_query( $connect, "SELECT id, season_rank, watched FROM $user WHERE epi_num = $i AND anime_name = '$rom_name' AND anime_season = '$season'" );
$record = mysqli_fetch_assoc( $result );
if ( mysqli_num_rows( $result ) > 0 ) {
   $rank = $record[ 'season_rank' ];
   $watched = $record[ 'watched' ];

   if ( $incdec == 0 ) {
      $watched++;
      mysqli_query( $connect, "UPDATE $user SET watched = $watched WHERE id = " . $record[ 'id' ] );
   } else if ( $incdec == 1 ) {
      if ( $watched > 1 ) {
         $watched--;
         mysqli_query( $connect, "UPDATE $user SET watched = $watched WHERE id = " . $record[ 'id' ] );
      } else {
         mysqli_query( $connect, "DELETE FROM $user WHERE id = " . $record[ 'id' ] );

         $result = mysqli_query( $connect, "SELECT id FROM $user WHERE epi_num = $i AND anime_name = '$rom_name' AND anime_season = '$season'" );
         $record = mysqli_fetch_assoc( $result );
         if ( mysqli_num_rows( $result ) < 1 ) {
            $result2 = mysqli_query( $connect2, "SELECT id, addedScore, numOfRanks, addedWatch FROM anime_shows WHERE rom_name = '$rom_name' AND season = '$season'" );
            $record2 = mysqli_fetch_assoc( $result2 );
            $score = ( isset( $record2[ 'addedScore' ] ) ? $record2[ 'addedScore' ] : 0 ) - $rank;
            $rankNum = ( isset( $record2[ 'numOfRanks' ] ) ? $record2[ 'numOfRanks' ] : 0 ) - 1;
            $watchNum = ( isset( $record2[ 'addedWatch' ] ) ? $record2[ 'addedWatch' ] : 0 ) - 1;

            mysqli_query( $connect2, "UPDATE anime_shows SET addedScore = $score, numOfRanks = $rankNum, addedWatch = $watchNum WHERE id = ".$record2['id']);
         }
      }
   }
}

mysqli_close( $connect );
mysqli_close( $connect2 );
?>