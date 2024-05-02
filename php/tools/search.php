<?php
include '../globalVars.php';

// Check if the 'q' parameter is set in the URL
if ( isset( $_GET[ 'q' ] ) ) {
   // Sanitize and escape the search query
   $searchTerm = mysqli_real_escape_string( $connect1, $_GET[ 'q' ] );
   $filter = $_GET[ 'filter' ];

   // Construct the SQL query to search for anime shows based on the rom_name
   if ($filter == "all") {
      $query = "
       (SELECT rom_name, image FROM anime WHERE rom_name LIKE '%$searchTerm%' OR eng_name LIKE '%$searchTerm%')
       UNION
       (SELECT rom_name, image FROM manga WHERE rom_name LIKE '%$searchTerm%' OR eng_name LIKE '%$searchTerm%')
       ORDER BY rom_name ASC LIMIT 6";
   } else {
      $query = "SELECT rom_name, image FROM $filter WHERE rom_name LIKE '%$searchTerm%' OR eng_name LIKE '%$searchTerm%' ORDER BY rom_name ASC LIMIT 6";
   }

   // Perform the query
   $result = mysqli_query( $connect1, $query );

   // Initialize an array to store the search results
   $searchResults = array();

   // Fetch and store the results in the array
   while ( $row = mysqli_fetch_assoc( $result ) ) {
      $searchResults[] = array(
         'name' => $row[ 'rom_name' ],
         'image' => $animeArts . $row[ 'image' ]
      );
   }

   // Return the search results as JSON
   echo json_encode( $searchResults );
} else {
   // If the 'q' parameter is not set, return an empty array
   echo json_encode( array() );
}
?>
