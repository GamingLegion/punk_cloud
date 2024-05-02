<?php
include '../globalVars.php';

if ( isset( $_GET[ 'q' ] ) ) {
   $searchTerm = mysqli_real_escape_string( $connect1, $_GET[ 'q' ] );
   $filter = $_GET[ 'filter' ];
   if ( $filter == "all" ) {
      $query = "
       (SELECT rom_name, image FROM anime WHERE rom_name LIKE '%$searchTerm%' OR eng_name LIKE '%$searchTerm%')
       UNION
       (SELECT rom_name, image FROM manga WHERE rom_name LIKE '%$searchTerm%' OR eng_name LIKE '%$searchTerm%')
       ORDER BY rom_name ASC LIMIT 6";
   } else {
      $query = "SELECT rom_name, image FROM $filter WHERE rom_name LIKE '%$searchTerm%' OR eng_name LIKE '%$searchTerm%' ORDER BY rom_name ASC LIMIT 6";
   }

   $result = mysqli_query( $connect1, $query );
   $searchResults = array();
   while ( $row = mysqli_fetch_assoc( $result ) ) {
      $searchResults[] = array(
         'name' => $row[ 'rom_name' ],
         'image' => $animeArts . $row[ 'image' ]
      );
   }
   echo json_encode( $searchResults );
} else {
   echo json_encode( array() );
}
?>
