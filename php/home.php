<!doctype html>
<html style="background-color: #222425">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PunkCloud Home</title>
<link rel="stylesheet" type="text/css" href="../css/home.css">
<link rel="stylesheet" type="text/css" href="../css/card.css">
   
<?php
$IPATH = $_SERVER[ "DOCUMENT_ROOT" ] . "/PunkCloud/php/components/";
include( $IPATH . "header.html" );
?>
</head>
<body>
<h1>Recently Added to the PunkCloud</h1>
<div class="new_added">
   <?php
   $connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
   $result = mysqli_query( $connect, 'Select eng_name, rom_name, image FROM anime_shows ORDER BY ins_date DESC' );

   while ( $record = mysqli_fetch_assoc( $result ) ) {
      echo '<div class="aniCard" id="card">';
      echo '<img src="../images/anime/' . $record[ 'image' ] . '" alt="' . $record[ 'eng_name' ] . '" width="auto" height="auto">';
      echo '<div class="text">';
      if ( $record[ 'eng_name' ] != NULL ) {
         echo '<p>' . $record[ 'eng_name' ] . '</p>';
      } else {
         echo '<p>' . $record[ 'rom_name' ] . '</p>';
      }
      echo '</div>';
      echo '</div>';
   }
   ?>
   <script src="../js/pageClick.js"></script> 
</div>
<h1>Recently Updated in the PunkCloud</h1>
<div class="new_added">
   <?php
   $connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
   $result = mysqli_query( $connect, 'Select eng_name, rom_name, image FROM anime_shows ORDER BY upd_date DESC' );

   while ( $record = mysqli_fetch_assoc( $result ) ) {
      echo '<div class="aniCard" id="card">';
      echo '<img src="../images/anime/' . $record[ 'image' ] . '" alt="' . $record[ 'eng_name' ] . '" width="auto" height="auto">';
      echo '<div class="text">';
      if ( $record[ 'eng_name' ] != NULL ) {
         echo '<p>' . $record[ 'eng_name' ] . '</p>';
      } else {
         echo '<p>' . $record[ 'rom_name' ] . '</p>';
      }
      echo '</div>';
      echo '</div>';
   }
   ?>
   <script src="../js/pageClick.js"></script> 
</div>
</body>
</html>
