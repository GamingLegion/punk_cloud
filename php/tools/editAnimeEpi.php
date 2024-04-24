<?php
$data = json_decode( file_get_contents( 'php://input' ), true );
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud_episodes' );

$name = $data[ 'name' ];
$field = $data[ 'field' ];
$value = $data[ 'value' ];

$anime_name = $data[ 'anime_name' ];
$anime_season = $data[ 'anime_season' ];
$epi_num = $data[ 'epi_num' ];

if ( $field == 'release_date' ) {
   $value = date( "Y-m-d", strtotime( $value ) );;
}
if($value == '') {
mysqli_query( $connect, "UPDATE anime
                        SET $field = NULL
                        WHERE name = '$name' 
                        OR (anime_name = '$anime_name' AND anime_season = '$anime_season' AND epi_num = $epi_num)" );
} else {
mysqli_query( $connect, "UPDATE anime 
                        SET $field = '$value'
                        WHERE name = '$name' 
                        OR (anime_name = '$anime_name' AND anime_season = '$anime_season' AND epi_num = $epi_num)" );
}

mysqli_close( $connect );
?>