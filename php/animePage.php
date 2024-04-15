<!DOCTYPE html>
<html lang="en_US" style="background-color: #222425">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../css/animePage.css">
<link rel="stylesheet" type="text/css" href="../css/seasons.css">
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
            <script src="../js/titleOverflow.js"></script> 
         </div>
      </div>
      <div class="anime-body">
         <div class="seasons">
            <?php
            $connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
            $name = isset( $_GET[ 'link' ] ) ? $_GET[ 'link' ] : 'default';
            $result = mysqli_query( $connect, "SELECT series, season, epi_num, start_date, end_date, air_season, brodcast, producers, licensors, studios FROM anime_shows WHERE series = '" . $name . "' ORDER BY season" );
            while ( $record = mysqli_fetch_assoc( $result ) ) {
               if ( $record[ 'season' ] !== NULL ) {
                  echo '<div class="collapsible">';
                  echo '<button class="collapsible-btn"><strong>' . $record[ 'season' ] . '</strong></button>';
                  echo '<div id="collapsible">';
                  echo '<div class="anime-description">';

                  echo '<div class="info_line">';
                  echo '<a><strong>Start Date:</strong></a>';
                  if ( $record[ 'start_date' ] !== NULL ) {
                     $start_date = new DateTime( $record[ 'start_date' ] );
                     $start_date = $start_date->format( 'F j, Y' );
                     echo '<a class="info" id="start_date">' . $start_date . '</a>';
                  } else {
                     echo '<a class="info" id="start_date"></a>';
                  }
                  echo '</div>';
                  echo '<div class="info_line"">';
                  echo '<a><strong>End Date:</strong></a>';
                  if ( $record[ 'end_date' ] !== NULL ) {
                     $end_date = new DateTime( $record[ 'end_date' ] );
                     $end_date = $end_date->format( 'F j, Y' );
                     echo '<a class="info" id="end_date">' . $end_date . '</a>';
                  } else {
                     echo '<a class="info" id="end_date"></a>';
                  }
                  echo '</div>';
                  echo '<div class="info_line">';
                  echo '<a><strong>Air Season:</strong></a>';
                  echo '<a class="info" id="air_season">' . $record[ 'air_season' ] . '</a>';
                  echo '</div>';
                  echo '<div class="info_line">';
                  echo '<a><strong>Brodcast:</strong></a>';
                  echo '<a class="info" id="brodcsat">' . $record[ 'brodcast' ] . '</a>';
                  echo '</div>';
                  echo '<div class="info_line" id="prods">';
                  echo '<a><strong>Producer(s):</strong></a>';
                  $prods = $record[ 'producers' ];
                  while ( strpos( $prods, ',' ) !== false ) {
                     echo '<a class="info" id="producers">' . substr( $prods, 0, strpos( $prods, ',' ) + 2) . '</a>';
                     $prods = substr( $prods, strpos( $prods, ',' ) + 2 );
                  }
                  echo '<a class="info" id="producers">' . $prods . '</a>';
                  echo '</div>';
                  echo '<div class="info_line">';
                  echo '<a><strong>Licensor(s):</strong></a>';
                  echo '<a class="info" id="licensors">' . $record[ 'licensors' ] . '' . '</a>';
                  echo '</div>';
                  echo '<div class="info_line">';
                  echo '<a><strong>Studio:</strong></a>';
                  echo '<a class="info" id="studios">' . $record[ 'studios' ] . '</a>';
                  echo '</div>';
                  echo '</div>';
                  echo '<div class="episode-section">';
                  for ( $i = 1; $i <= $record[ 'epi_num' ]; $i++ ) {
                     echo '<div class="episode hidden">';
                     echo '<div class="episode-thumbnail"> <img src="episode' . $i . '.jpg" alt="Episode ' . $i . '"> </div>';
                     echo '<div class="episode-details">';
                     echo '<div class="episode-info">';
                     echo '<h3 class="episode-title">Episode ' . $i . '</h3>';
                     echo '<button class="checkbox-btn"></button>';
                     echo '</div>';
                     echo '</div>';
                     echo '</div>';
                  }
                  echo '</div>';
                  echo '</div>';
               }
            }
            ?>
            <script src="../js/editAnime.js"></script> 
         </div>
      </div>
      <script src="../js/seasonsCollapse.js"></script> 
   </div>
</div>
</div>
</body>
</html>