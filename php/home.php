<!doctype html>
<html style="background-color: #222425">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PunkCloud Home</title>
<link rel="stylesheet" type="text/css" href="../css/home.css">
<link rel="stylesheet" type="text/css" href="../css/card.css">
<?php
session_start();
$IPATH = $_SERVER[ "DOCUMENT_ROOT" ] . "/PunkCloud/php/components/";
include( $IPATH . "header.php" );
?>
</head>
<body>
<h1>Recently Added</h1>
<div class="new_added">
   <?php
   $connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
   $result = mysqli_query( $connect, 'Select eng_name, rom_name, image, series FROM anime ORDER BY ins_date DESC' );

   for ( $i = 0; $i < 9; $i++ ) {
      $record = mysqli_fetch_assoc( $result );
      echo '<div class="aniCard" id="card">';
      echo '<div id="thumbnail">';
      echo '<img src="../images/arts/anime/' . $record[ 'image' ] . '" alt="' . $record[ 'eng_name' ] . '">';
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
   ?>
   <script src="../js/pageClick.js"></script> 
</div>
<h1>Recently Updated</h1>
<div class="new_added">
   <?php
   $connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
   $result = mysqli_query( $connect, 'Select eng_name, rom_name, image, series FROM anime ORDER BY upd_date DESC' );

   for ( $i = 0; $i < 9; $i++ ) {
      $record = mysqli_fetch_assoc( $result );
      echo '<div class="aniCard" id="card">';
      echo '<div id="thumbnail">';
      echo '<img src="../images/arts/anime/' . $record[ 'image' ] . '" alt="' . $record[ 'eng_name' ] . '">';
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
   ?>
   <script src="../js/pageClick.js"></script> 
</div>
</body>
</html>
