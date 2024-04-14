<?php
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );

if ( isset( $_POST[ 'submit' ] ) ) {
   date_default_timezone_set( 'America/New_York' );
   $ins_date = date( "Y-m-d H:i:s" );
   $rom_name = $_POST[ 'rom_name' ];
   $eng_name = ( $_POST[ 'eng_name' ] !== "" ) ? $_POST[ 'eng_name' ] : NULL;
   $image = ( $_POST[ 'image' ] !== "" ) ? $_POST[ 'image' ] : 'deafult.png';

   if ( $rom_name !== NULL ) {
      if ( $eng_name !== NULL ) {
         $eng_name = str_replace( "'", "\'", $eng_name );
         $eng_name = str_replace( "\"", "\"", $eng_name );
      }
      $rom_name = str_replace( "'", "\'", $rom_name );
      $rom_name = str_replace( "\"", "\"", $rom_name );

      mysqli_query( $connect, "INSERT INTO $entry_type(id, ins_date, upd_date, eng_name, rom_name, image) VALUES ('NULL', '$ins_date', '$ins_date', '$eng_name', '$rom_name', '$image');" );
      mysqli_close( $connect );
      header( "Location: http://localhost/PunkCloud/php/home.php" );
   }
}
?>