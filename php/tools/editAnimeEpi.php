<?php
$data = json_decode( file_get_contents( 'php://input' ), true );
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud_episodes' );

$field = $data[ 'field' ];
$value = $data[ 'value' ];
$anime_name = $data[ 'anime_name' ];
$anime_season = $data[ 'anime_season' ];
$epi_num = $data[ 'epi_num' ];

if ( $field == 'release_date' ) {
   $value = date( "Y-m-d", strtotime( $value ) );;
}
if ( $value == '' ) {
   mysqli_query( $connect, "UPDATE anime SET $field = NULL
                        WHERE anime_name = '$anime_name' AND anime_season = '$anime_season' AND epi_num = $epi_num" );
} else {
   $stmt = $connect->prepare( "UPDATE anime SET $field = ? WHERE anime_name = ? AND anime_season = ? AND epi_num = ?" );
   $stmt->bind_param( "sssi", $value, $anime_name, $anime_season, $epi_num );
   $stmt->execute();
   $stmt->close();
}

mysqli_close( $connect );
?>
