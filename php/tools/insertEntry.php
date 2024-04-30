<?php
include '../globalVars.php';

if ( isset( $_POST[ 'submit' ] ) ) {
   date_default_timezone_set( 'America/New_York' );
   $ins_date = date( "Y-m-d H:i:s" );
   $rom_name = $_POST[ 'rom_name' ];
   $eng_name = ( $_POST[ 'eng_name' ] !== "" ) ? $_POST[ 'eng_name' ] : NULL;
   $image = ( $_POST[ 'image' ] !== "" ) ? $_POST[ 'image' ] : 'default.png';
   $epis = ( $_POST[ 'epis' ] !== "" ) ? $_POST[ 'epis' ] : 0;
   $series = $_POST[ 'series' ];
   $season = $_POST[ 'season' ];

   $rom_name = str_replace( "'", "\'", $rom_name );
   $rom_name = str_replace( "\"", "\"", $rom_name );
   mysqli_query( $connect1, "INSERT INTO anime(id, ins_date, upd_date, rom_name, image, epi_num, series, season) VALUES ('NULL', '$ins_date', '$ins_date', '$rom_name', '$image', '$epis', '$series', '$season');" );

   if ( $eng_name !== NULL && $eng_name !== "" ) {
      $eng_name = str_replace( "'", "\'", $eng_name );
      $eng_name = str_replace( "\"", "\"", $eng_name );
      mysqli_query( $connect1, "UPDATE anime SET eng_name = '$eng_name' WHERE rom_name = '$rom_name'" );
   }
   if ( strpos( $season, 'Season' ) === false && strpos( $season, 'Arc' ) === false ) {
      $season = 'Season: ' . $season;
   }
   
   header( "Location: http://localhost/PunkCloud/php/pages/home.php" );
}
mysqli_close( $connect );
?>