<?php
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );

if ( isset( $_POST[ 'submit' ] ) ) {
   date_default_timezone_set( 'America/New_York' );
   $ins_date = date( "Y-m-d H:i:s" );
   $eng_name = $_POST[ 'eng_name' ];
   $rom_name = $_POST[ 'rom_name' ];
   $entry_type = $_POST[ 'entry_type' ];
   $image = $_POST[ 'image' ];

   if ( $eng_name !== NULL && $rom_name !== NULL ) {
      $eng_name = str_replace( "'", "\'", $eng_name );
      $eng_name = str_replace( "\"", "\"", $eng_name );
      $rom_name = str_replace( "'", "\'", $rom_name );
      $rom_name = str_replace( "\"", "\"", $rom_name );

      mysqli_query( $connect, "INSERT INTO $entry_type(id, ins_date, upd_date, eng_name, rom_name, image)
	VALUES ('NULL', '$ins_date', '$ins_date', '$eng_name', '$rom_name', '$image');" );
      mysqli_close( $connect );
      header( "Location: http://localhost/PunkCloud/php/home.php" );
   }
}
?>