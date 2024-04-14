<!DOCTYPE html>
<html lang="en_US" style="background-color: #222425">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../css/animePage.css">
<link rel="stylesheet" type="text/css" href="../css/episode.css">
<?php
$IPATH = $_SERVER[ "DOCUMENT_ROOT" ] . "/PunkCloud/php/components/";
include( $IPATH . "header.html" );
?>
<title>Anime Page</title>
</head>
<body>
<div class="container">
   <div class="anime-details">
      <div class="anime-header">
         <div class="anime-image">
            <?php
            $connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
            $name = isset( $_GET[ 'link' ] ) ? $_GET[ 'link' ] : 'default';
            $result = mysqli_query( $connect, "SELECT image FROM anime_shows WHERE rom_name='" . $name . "'" );
            $record = mysqli_fetch_assoc( $result );

            echo '<img src="../images/anime/' . $record[ 'image' ] . '" id="image">';
            mysqli_close( $connect );
            ?>
         </div>
         <div class="anime-names">
            <?php
            $connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
            $name = isset( $_GET[ 'link' ] ) ? $_GET[ 'link' ] : 'default';
            $result = mysqli_query( $connect, "SELECT eng_name, rom_name FROM anime_shows WHERE rom_name='" . $name . "'" );
            $record = mysqli_fetch_assoc( $result );

            echo '<div class="anime-name">';
            echo '<p class="rom_name">' . $record[ 'rom_name' ] . '</p>';
            echo '</div>';
            if ( $record[ 'eng_name' ] !== NULL ) {
               echo '<div class="anime-name">';
               echo '<p class="eng_name">' . $record[ 'eng_name' ] . '</p>';
               echo '</div>';
            }
            mysqli_close( $connect );
            ?>
         </div>
      </div>
      <div class="anime-body">
         <div class="anime-description">
            <?php
            $connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
            $name = isset( $_GET[ 'link' ] ) ? $_GET[ 'link' ] : 'default';
            $result = mysqli_query( $connect, "SELECT series, epi_num, status, start_date, end_date, air_season, brodcast, producers, licensors, studios, source, genres, demographic FROM anime_shows WHERE rom_name='" . $name . "'" );
            $record = mysqli_fetch_assoc( $result );

            echo '<div class="info_line">';
            echo '<p><strong>Start Date:</strong></p>';
            if ( $record[ 'start_date' ] !== NULL ) {
               $start_date = new DateTime( $record[ 'start_date' ] );
               $start_date = $start_date->format( 'F j, Y' );
               echo '<p class="info" id="start_date">' . $start_date . '</p>';
            } else {
               echo '<p class="info" id="start_date"></p>';
            }
            echo '</div>';
            echo '<div class="info_line">';
            echo '<p><strong>End Date:</strong></p>';
            if ( $record[ 'end_date' ] !== NULL ) {
               $end_date = new DateTime( $record[ 'end_date' ] );
               $end_date = $end_date->format( 'F j, Y' );
               echo '<p class="info" id="end_date">' . $end_date . '</p>';
            } else {
               echo '<p class="info" id="end_date"></p>';
            }
            echo '</div>';
            echo '<div class="info_line">';
            echo '<p><strong>Air Season:</strong></p>';
            echo '<p class="info" id="air_season">' . $record[ 'air_season' ] . '</p>';
            echo '</div>';
            echo '<div class="info_line">';
            echo '<p><strong>Brodcast:</strong></p>';
            echo '<p class="info" id="brodcast">' . $record[ 'brodcast' ] . '</p>';
            echo '</div>';
            echo '<div class="info_line">';
            echo '<p><strong>Producers:</strong></p>';
            echo '<p class="info" id="producers">' . $record[ 'producers' ] . '</p>';
            echo '</div>';
            echo '<div class="info_line">';
            echo '<p><strong>Licensors:</strong></p>';
            echo '<p class="info" id="licensors">' . $record[ 'licensors' ] . '</p>';
            echo '</div>';
            echo '<div class="info_line">';
            echo '<p><strong>Studios:</strong></p>';
            echo '<p class="info" id="studios">' . $record[ 'studios' ] . '</p>';
            echo '</div>';
            echo '<div class="info_line">';
            echo '<p><strong>Source:</strong></p>';
            echo '<p class="info" id="source">' . $record[ 'source' ] . '</p>';
            echo '</div>';
            echo '<div class="info_line">';
            echo '<p><strong>Genres:</strong></p>';
            echo '<p class="info" id="genres">' . $record[ 'genres' ] . '</p>';
            echo '</div>';
            echo '<div class="info_line">';
            echo '<p><strong>Demographic:</strong></p>';
            echo '<p class="info" id="demographic">' . $record[ 'demographic' ] . '</p>';
            echo '</div>';
            mysqli_close( $connect );
            ?>
         </div>
         <script src="../js/editAnime.js"></script> 
         <div class="seasons">
            <div class="collapsible">
               <button class="collapsible-btn"><strong>Season 1</strong></button>
               <div class="episode-section">
                  <?php
                  $connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
                  $name = isset( $_GET[ 'link' ] ) ? $_GET[ 'link' ] : 'default';
                  $result = mysqli_query( $connect, "SELECT epi_num FROM anime_shows WHERE rom_name='" . $name . "'" );
                  $record = mysqli_fetch_assoc( $result );

                  for ( $i = 1; $i <= $record[ 'epi_num' ]; $i++ ) {
                     echo '<div class="episode hidden">';
                     echo '<div class="episode-thumbnail"> <img src="episode' . $i . '.jpg" alt="Episode ' . $i . '"> </div>';
                     echo '<div class="episode-details">';
                     echo '<div class="episode-info">';
                     echo '<h3 class="episode-title">Episode ' . $i . '</h3>';
                     echo '<button class="checkbox-btn"></button>'; // Add the button here
                     echo '</div>';
                     echo '</div>';
                     echo '</div>';
                  }
                  ?>
               </div>
            </div>
            <div class="collapsible">
               <button class="collapsible-btn"><strong>Season 2</strong></button>
               <div class="episode-section">
                  <?php
                  $connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
                  $name = isset( $_GET[ 'link' ] ) ? $_GET[ 'link' ] : 'default';
                  $result = mysqli_query( $connect, "SELECT epi_num FROM anime_shows WHERE rom_name='" . $name . "'" );
                  $record = mysqli_fetch_assoc( $result );

                  for ( $i = 1; $i <= $record[ 'epi_num' ]; $i++ ) {
                     echo '<div class="episode hidden">';
                     echo '<div class="episode-thumbnail"> <img src="episode' . $i . '.jpg" alt="Episode ' . $i . '"> </div>';
                     echo '<div class="episode-details">';
                     echo '<div class="episode-info">';
                     echo '<h3 class="episode-title">Episode ' . $i . '</h3>';
                     echo '<button class="checkbox-btn"></button>'; // Add the button here
                     echo '</div>';
                     echo '</div>';
                     echo '</div>';
                  }
                  ?>
               </div>
            </div>
         </div>
         <script src="../js/episodeCollapse.js"></script> 
      </div>
   </div>
</div>
</body>
</html>