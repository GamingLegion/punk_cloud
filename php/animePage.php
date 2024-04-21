<!DOCTYPE html>
<html lang="en_US" style="background-color: #222425">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../css/animePage.css">
<link rel="stylesheet" type="text/css" href="../css/seasons.css">
<link rel="stylesheet" type="text/css" href="../css/episodeOverlay.css">
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
         <div class="rankings">
            <div class="overScore"> <a></a> </div>
            <div class="overRank"> </div>
         </div>
      </div>
      <div class="anime-body">
         <div class="seasons">
            <?php
            $connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
            $connect2 = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud_episodes' );
            $connect3 = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud_users' );

            $name = isset( $_GET[ 'link' ] ) ? $_GET[ 'link' ] : 'default';
            $result = mysqli_query( $connect, "SELECT rom_name, image, series, season, epi_num, start_date, end_date, air_season, brodcast, producers, licensors, studios, addedScore, numOfRanks, addedWatch FROM anime_shows WHERE series = '" . $name . "' ORDER BY season" );

            while ( $record = mysqli_fetch_assoc( $result ) ) {
               if ( $record[ 'season' ] !== NULL ) {
                  echo '<div class="collapsible">';
                  echo '<button class="collapsible-btn"><strong>' . $record[ 'season' ] . '</strong></button>';
                  if ( isset( $_SESSION[ 'user' ] ) ) {
                     $query = "SELECT epi_num 
                          FROM " . $_SESSION[ 'user' ] . "
                          WHERE anime_name = '" . $record[ 'rom_name' ] . "' 
                          AND anime_season = '" . $record[ 'season' ] . "'";
                     $result3 = mysqli_query( $connect3, $query );
                     if ( mysqli_num_rows( $result3 ) == $record[ 'epi_num' ] ) {
                        echo '<button class="checkbox-btn checked" id="sectionCheck"></button>';
                     } else {
                        echo '<button class="checkbox-btn unchecked" id="sectionCheck"></button>';
                     }
                  }
                  echo '<div id="collapsible">';
                  echo '<input type="hidden" value="' . $record[ 'season' ] . '">';
                  echo '<div class="anime-left">';
                  echo '<div class="anime-description">';
                  echo '<img src="../images/arts/anime/' . $record[ 'image' ] . '" id="image">';
                  echo '<div class="info_line" style="text-align: center;">';
                  echo '<a><strong></strong></a>';
                  echo '<a class="info" id="season_name">' . $record[ 'rom_name' ] . '</a>';
                  echo '</div>';
                  echo '</div>';

                  $score = 0;
                  $popularity = 0;
                  if ( isset( $record[ 'addedScore' ] ) && isset( $record[ 'numOfRanks' ] ) ) {
                     if ( $record[ 'numOfRanks' ] > 0 ) {
                        $score = $record[ 'addedScore' ] / $record[ 'numOfRanks' ];
                        $score = number_format( $score, 2 );
                     }
                  }
                  if ( isset( $record[ 'addedWatch' ] ) ) {
                     $popularity = $record[ 'addedWatch' ];
                  }
                  echo '<div class="anime-description">';
                  echo '<div class="i_l">';
                  echo '<a><strong>Season Score:</strong></a>';
                  echo '<a class="info" id="season_score">' . $score . ' / 10</a>';
                  echo '</div>';
                  echo '<div class="i_l">';
                  echo '<a><strong>Season Popularity:</strong></a>';
                  echo '<a class="info" id="season_popularity">#' . $popularity . '</a>';

                  if ( isset( $_SESSION[ 'user' ] ) ) {
                     $result3 = mysqli_query( $connect3, "SELECT season_rank FROM " . $_SESSION[ 'user' ] . " WHERE anime_name = '" . $record[ 'rom_name' ] . "'" );
                     $record3 = mysqli_fetch_assoc( $result3 );
                     $rank = isset( $record3[ 'season_rank' ] ) ? $record3[ 'season_rank' ] : "Select Score";
                     echo '<br><br>';
                     echo '<div class="i_l" style="display: flex;">';
                     echo '<a><strong>User Score:</strong></a>';
                     echo '<div class="dropdown">';
                     echo '<select name="user_score">';
                     echo '<option value="Select Score">Select Score</option>';

                     $options = array(
                        "10" => "(10) God Tier",
                        "9" => "(9) Insane",
                        "8" => "(8) Amazing",
                        "7" => "(7) Great",
                        "6" => "(6) Good",
                        "5" => "(5) Mid",
                        "4" => "(4) Bad",
                        "3" => "(3) Poor",
                        "2" => "(2) Terrible",
                        "1" => "(1) Abysmal",
                        "0" => "(0) Dear Lord"
                     );

                     foreach ( $options as $value => $label ) {
                        if ( $rank == $value ) {
                           echo '<option value="' . $value . '" selected>' . $label . '</option>';
                        } else {
                           echo '<option value="' . $value . '">' . $label . '</option>';
                        }
                     }
                     echo '</select>';
                     echo '</div>';
                     echo '</div>';
                  }
                  echo '</div>';
                  echo '</div>';

                  echo '<button class="season_info">Show Season Info</button>';
                  echo '<div class="anime-description" style="display: none;">';
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
                  echo '<div class="info_line">';
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
                  echo '</div>';

                  $result2 = mysqli_query( $connect2, "SELECT name, thumbnail, release_date
                  FROM anime_shows 
                  WHERE anime_series = '" . $name . "' 
                  AND anime_season = '" . $record[ 'season' ] . "' 
                  ORDER BY epi_num" );
                  echo '<div class="episode-section">';
                  for ( $i = 1; $i <= $record[ 'epi_num' ]; $i++ ) {
                     $record2 = mysqli_fetch_assoc( $result2 );
                     echo '<div class="episode hidden">';
                     echo '<div class="episode-thumbnail">';
                     $thumbnail = 'default.jpg';
                     if ( isset( $record2[ 'thumbnail' ] ) ) {
                        $thumbnail = $record2[ 'thumbnail' ];
                     }
                     echo '<img src="../images/episodes/anime/' . $thumbnail . '" alt="Episode ' . $i . '">';
                     echo '</div>';
                     echo '<div class="episode-details">';
                     echo '<div class="episode-info" id="' . $record[ 'season' ] . '">';
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

                        $query = "SELECT epi_num 
                          FROM " . $_SESSION[ 'user' ] . "
                          WHERE anime_name = '" . $record[ 'rom_name' ] . "' 
                          AND anime_season = '" . $record[ 'season' ] . "'";
                        $result3 = mysqli_query( $connect3, $query );
                        $check = false;
                        echo '<div>';
                        while ( $record3 = mysqli_fetch_assoc( $result3 ) ) {
                           if ( $record3[ 'epi_num' ] == $i ) {
                              echo '<button class="checkbox-btn checked"></button>';
                              $check = true;
                           }
                        }
                        if ( !$check ) {
                           echo '<button class="checkbox-btn unchecked"></button>';
                        }
                        echo '</div>';
                     } else {
                        echo '<input type="hidden" name="username" value="">';
                     }
                     echo '<input type="hidden" name="epi_num" value="' . $i . '">';
                     echo '<input type="hidden" name="rom_name" value="' . $record[ 'rom_name' ] . '">';
                     $rel_date = '';
                     if ( isset( $record2[ 'release_date' ] ) ) {
                        $rel_date = new DateTime( $record2[ 'release_date' ] );
                        $rel_date = $rel_date->format( 'F j, Y' );
                     }
                     echo '<input type="hidden" name="release_date" value="' . $rel_date . '">';
                     echo '</div>';
                     echo '</div>';
                     echo '</div>';
                  }
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
               }
            }
            mysqli_close( $connect );
            mysqli_close( $connect2 );
            mysqli_close( $connect3 );
            ?>
         </div>
      </div>
      <script src="../js/seasonsCollapse.js"></script> 
   </div>
</div>
</div>
</div>
</div>
<?php
echo '<div id="episodeOverlay">';
echo '<input type="hidden" name="anime_name" value="">';
echo '<input type="hidden" name="anime_season" value="">';
echo '<input type="hidden" name="epi_num" value="">';
if ( isset( $_SESSION[ 'user' ] ) ) {
   echo '<input type="hidden" name="user" value="' . $_SESSION[ 'user' ] . '">';
} else {
   echo '<input type="hidden" name="user" value="">';
}
echo '<div id=overlayImg>';
echo '<img>';
echo '</div>';
echo '<div id="titleLine">';
echo '<p class="overlay-content" id="title"></p>';
if ( isset( $_SESSION[ 'user' ] ) ) {
   echo '<button class="overlayCheck"></button>';
}
echo '</div>';
echo '<div id="episode-release-date">';
echo '<p>Release Date:</p>';
echo '<p id="release_date">N/A</p>';
echo '</div>';
echo '<div id="episode-description">';
echo '<p>Description:</p>';
echo '<p id="description">N/A</p>';
echo '</div>';
echo '</div>';
if ( isset( $_SESSION[ 'user' ] ) ) {
   if ( $_SESSION[ 'user' ] === 'oracle' ) {
      echo '<script src="../js/editAnime.js"></script>';
      echo '<script src="../js/editAnimeEpi.js"></script>';
   }
}
?>
<script src="../js/episodeOverlay.js"></script> 
<script src="../js/epiCheck.js"></script> 
<script src="../js/changeRank.js"></script>
</body>
</html>