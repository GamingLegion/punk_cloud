<?php
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
$connect2 = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud_episodes' );
$data = json_decode( file_get_contents( 'php://input' ), true );

date_default_timezone_set( 'America/New_York' );
$ins_date = date( "Y-m-d H:i:s" );
$epi_num = $data[ 'epi_num' ];
$rom_name = $data[ 'rom_name' ];
$series = $data[ 'series' ];
$season = $data[ 'season' ];


mysqli_query( $connect2, "INSERT INTO anime(id, ins_date, epi_num, anime_series, anime_name, anime_season, thumbnail) VALUES ('NULL', '$ins_date', '$epi_num', '$series', '$rom_name', '$season', 'default.jpg');" );
mysqli_query( $connect, "UPDATE anime SET epi_num = epi_num + 1 WHERE rom_name = '$rom_name'" );
?>