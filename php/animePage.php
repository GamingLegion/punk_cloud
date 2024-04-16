<!DOCTYPE html>
<html lang="en_US" style="background-color: #222425">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../css/animePage.css">
<link rel="stylesheet" type="text/css" href="../css/seasons.css">
<title>Anime Page</title>
<?php
session_start();
$IPATH = $_SERVER[ "DOCUMENT_ROOT" ] . "/PunkCloud/php/components/";
include( $IPATH . "header.php" );
?>
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

            echo '<img src="../images/arts/anime/' . $record[ 'image' ] . '" id="image">';
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
            $connect2 = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud_episodes' );
            $connect3 = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud_users' );

            $name = isset( $_GET[ 'link' ] ) ? $_GET[ 'link' ] : 'default';
            $result = mysqli_query( $connect, "SELECT rom_name, image, series, season, epi_num, start_date, end_date, air_season, brodcast, producers, licensors, studios FROM anime_shows WHERE series = '" . $name . "' ORDER BY season" );

            while ( $record = mysqli_fetch_assoc( $result ) ) {
               if ( $record[ 'season' ] !== NULL ) {
                  echo '<div class="collapsible">';
                  echo '<button class="collapsible-btn"><strong>' . $record[ 'season' ] . '</strong></button>';
                  echo '<div id="collapsible">';
                  echo '<div class="anime-description">';

                  echo '<img src="../images/arts/anime/' . $record[ 'image' ] . '" id="image">';
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
                  if ( $prods !== NULL ) {
                     while ( strpos( $prods, ',' ) !== false ) {
                        echo '<a class="info" id="producers">' . substr( $prods, 0, strpos( $prods, ',' ) + 2 ) . '</a>';
                        $prods = substr( $prods, strpos( $prods, ',' ) + 2 );
                     }
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

                  $result2 = mysqli_query( $connect2, "SELECT name 
                  FROM anime_shows 
                  WHERE anime_series = '" . $name . "' 
                  AND anime_season = '" . $record[ 'season' ] . "' 
                  ORDER BY epi_num" );
                  echo '<div class="episode-section">';
                  for ( $i = 1; $i <= $record[ 'epi_num' ]; $i++ ) {
                     $record2 = mysqli_fetch_assoc( $result2 );
                     echo '<div class="episode hidden">';
                     echo '<div class="episode-thumbnail">';
                     $ei = $record[ 'image' ];
                     $ei = substr( $ei, 0, strlen( $ei ) - 4 );
                     echo '<img src="../images/episodes/anime/' . $ei . '/' . $i . '.jpg" alt="Episode ' . $i . '">';
                     echo '</div>';
                     echo '<div class="episode-details">';
                     echo '<div class="episode-info">';
                     $epi_name = '';
                     if ( !is_null( $record2 ) ) {
                        if ( $record2[ 'name' ] !== NULL ) {
                           $epi_name = $record2[ 'name' ];
                        } else {
                           $epi_name = 'Episode ' . $i;
                        }
                     } else {
                        $epi_name = 'Episode ' . $i;
                     }
                     echo '<h3 class="episode-title">' . $epi_name . '</h3>';
                     if ( isset( $_SESSION[ 'user' ] ) ) {
                        echo '<input type="hidden" name="username" value="' . $_SESSION[ 'user' ] . '">';
                        echo '<input type="hidden" name="epi_num" value="' . $i . '">';
                        echo '<input type="hidden" name="rom_name" value="' . $record[ 'rom_name' ] . '">';
                        echo '<input type="hidden" name="season" value="' . $record[ 'season' ] . '">';

                        $query = "SELECT epi_num 
                          FROM " . $_SESSION[ 'user' ] . "
                          WHERE anime_name = '" . $record[ 'rom_name' ] . "' 
                          AND anime_season = '" . $record[ 'season' ] . "'";
                        $result3 = mysqli_query( $connect3, $query );
                        $check = false;
                        while ( $record3 = mysqli_fetch_assoc( $result3 ) ) {
                           if ( $record3[ 'epi_num' ] == $i ) {
                              echo '<button class="checkbox-btn checked"></button>';
                              $check = true;
                           }
                        }
                        if ( !$check ) {
                           echo '<button class="checkbox-btn unchecked"></button>';
                        }
                     }
                     echo '</div>';
                     echo '</div>';
                     echo '</div>';
                  }
                  echo '</div>';
                  echo '</div>';
               }
            }
            mysqli_close( $connect );
            mysqli_close( $connect2 );
            mysqli_close( $connect3 );

            if ( isset( $_SESSION[ 'user' ] ) ) {
               if ( $_SESSION[ 'user' ] === 'oracle' ) {
                  echo '<script src="../js/editAnime.js"></script>';
               }
            }
            ?>
            <script src="../js/epiCheck.js"></script> 
         </div>
      </div>
      <script src="../js/seasonsCollapse.js"></script> 
   </div>
</div>
</div>
</body>
</html>