<!doctype html>
<html lang="en" style="background-color: #222425">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PunkCloud Home</title>
<?php
session_start();
include '../globalVars.php';

echo '<link rel="stylesheet" type="text/css" href="' . $css . 'home.css">';
echo '<link rel="stylesheet" type="text/css" href="' . $css . 'card.css">';
include( $header );
?>
</head>
<body>
<?php
echo '<h1>Recently Added</h1>';
echo '<div class="new_added">';
$result = mysqli_query( $connect1, 'Select eng_name, rom_name, image, series FROM anime ORDER BY ins_date DESC LIMIT 9' );

while ( $record = mysqli_fetch_assoc( $result ) ) {
   echo '<div class="aniCard" id="card">';
   echo '<div id="thumbnail">';
   echo '<img src="' . $animeArts . $record[ 'image' ] . '" alt="' . $record[ 'rom_name' ] . '">';
   echo '<div class="title">';
   if ( $record[ 'eng_name' ] != NULL ) {
      echo '<p title="' . $record[ 'series' ] . '">' . $record[ 'eng_name' ] . '</p>';
   } else {
      echo '<p title="' . $record[ 'series' ] . '">' . $record[ 'rom_name' ] . '</p>';
   }
   echo '</div>';
   echo '</div>';
   echo '</div>';
}
echo '</div>';
echo '<h1>Recently Updated</h1>';
echo '<div class="new_added">';
$result = mysqli_query( $connect1, 'Select eng_name, rom_name, image, series FROM anime ORDER BY upd_date DESC LIMIT 9' );

while ( $record = mysqli_fetch_assoc( $result ) ) {
   echo '<div class="aniCard" id="card">';
   echo '<div id="thumbnail">';
   echo '<img src="' . $animeArts . $record[ 'image' ] . '" alt="' . $record[ 'rom_name' ] . '">';
   echo '<div class="title">';
   if ( $record[ 'eng_name' ] != NULL ) {
      echo '<p title="' . $record[ 'series' ] . '">' . $record[ 'eng_name' ] . '</p>';
   } else {
      echo '<p title="' . $record[ 'series' ] . '">' . $record[ 'rom_name' ] . '</p>';
   }
   echo '</div>';
   echo '</div>';
   echo '</div>';
}
echo '</div>';
echo '<script src="' . $js . 'pageClick.js"></script> ';
?>
</body>
</html>
