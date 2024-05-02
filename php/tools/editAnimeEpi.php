<?php
include '../globalVars.php';
$data = json_decode( file_get_contents( 'php://input' ), true );

$field = $data[ 'field' ];
$value = $data[ 'value' ];
$anime_name = $data[ 'anime_name' ];
$anime_season = $data[ 'anime_season' ];
$epi_num = $data[ 'epi_num' ];

if ( $field == 'release_date' ) {
   $value = date( "Y-m-d", strtotime( $value ) );;
}

if ( $value == '' ) {
   mysqli_query( $connect2, "UPDATE anime SET $field = NULL
                        WHERE anime_name = '$anime_name' AND anime_season = '$anime_season' AND epi_num = $epi_num" );
} else {
   $stmt = $connect2->prepare( "UPDATE anime SET $field = ? WHERE anime_name = ? AND anime_season = ? AND epi_num = ?" );
   $stmt->bind_param( "sssi", $value, $anime_name, $anime_season, $epi_num );
   $stmt->execute();
   $stmt->close();
}
?>
