<!DOCTYPE html>
<html lang="en_US" style="background-color: #222425">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Anime Page</title>
<?php
session_start();
include '../globalVars.php';

echo '<link rel="stylesheet" type="text/css" href="' . $css . 'animePage.css">';
echo '<link rel="stylesheet" type="text/css" href="' . $css . 'collapsable.css">';
echo '<link rel="stylesheet" type="text/css" href="' . $css . 'episode.css">';
echo '<link rel="stylesheet" type="text/css" href="' . $css . 'episodeOverlay.css">';
include( $header );
?>
</head>
<body>
<div class="container">
   <div class="anime-details">
      <div class="anime-header">
         <?php
         $name = isset( $_GET[ 'link' ] ) ? $_GET[ 'link' ] : 'default';
         $result = mysqli_query( $connect1, "SELECT eng_name, rom_name, image, source, genres, demographic FROM anime WHERE rom_name='" . $name . "'" );
         $record = mysqli_fetch_assoc( $result );

         echo '<div class="anime-image">';
         echo '<div class="anime-image-sub">';
         echo '<img src="' . $animeArts . $record[ 'image' ] . '" id="image">';
         echo '</div>';
         echo '</div>';
         echo '<div class="anime-names">';
         echo '<div class="anime-name">';
         echo '<p class="rom_name">' . $record[ 'rom_name' ] . '</p>';
         echo '</div>';
         if ( isset( $record[ 'eng_name' ] ) ) {
            echo '<div class="anime-name">';
            echo '<p class="eng_name">' . $record[ 'eng_name' ] . '</p>';
            echo '</div>';
         }
         echo '<script src="' . $apjs . 'titleOverflow.js"></script>';

         $result2 = mysqli_query( $connect1, "SELECT addedScore, numOfRanks FROM anime WHERE series = '" . $name . "'" );
         $score = 0;
         $ranks = 0;
         $maxRanks = 0;
         while ( $record2 = mysqli_fetch_assoc( $result2 ) ) {
            $score += $record2[ 'addedScore' ];
            $ranks += $record2[ 'numOfRanks' ];
            $maxRanks = max( $maxRanks, $record2[ 'numOfRanks' ] );
         }
         mysqli_free_result( $result2 );

         $result2 = mysqli_query( $connect1, "SELECT series, addedWatch FROM anime" );
         $map = [];
         while ( $record2 = mysqli_fetch_assoc( $result2 ) ) {
            if ( isset( $map[ $record2[ 'series' ] ] ) ) {
               $map[ $record2[ 'series' ] ] = max( $map[ $record2[ 'series' ] ], $record2[ 'addedWatch' ] );
            } else {
               $map[ $record2[ 'series' ] ] = $record2[ 'addedWatch' ];
            }
         }
         mysqli_free_result( $result2 );
         arsort( $map );
         $rank = 1;
         $val = 0;
         foreach ( $map as $key => $value ) {
            if ( $value === $map[ $name ] ) {
               $val = $value;
               break;
            }
            $rank++;
         }

         $result2 = mysqli_query( $connect1, "SELECT series, addedScore, numOfRanks FROM anime" );
         $map2 = [];
         $map3 = [];
         while ( $record2 = mysqli_fetch_assoc( $result2 ) ) {
            if ( isset( $map2[ $record2[ 'series' ] ] ) ) {
               $map2[ $record2[ 'series' ] ] = max( $map2[ $record2[ 'series' ] ], $record2[ 'addedScore' ] );
               $map3[ $record2[ 'series' ] ] = max( $map3[ $record2[ 'series' ] ], $record2[ 'numOfRanks' ] );
            } else {
               $map2[ $record2[ 'series' ] ] = $record2[ 'addedScore' ];
               $map3[ $record2[ 'series' ] ] = $record2[ 'numOfRanks' ];
            }
         }
         mysqli_free_result( $result2 );
         $map4 = [];
         foreach ( $map2 as $key => $value ) {
            $map4[ $key ] = ( $map3[ $key ] > 0 ) ? $map2[ $key ] / $map3[ $key ] : 0;
         }
         arsort( $map4 );
         $rank2 = 1;
         foreach ( $map4 as $key => $value ) {
            if ( $value === $map4[ $name ] ) {
               break;
            }
            $rank2++;
         }

         echo '<div class="anime_header_info_wrapper">';
         echo '<div class="anime_header_info">';
         echo '<div class="i_l">';
         echo '<a><strong>Anime Score:</strong></a>';
         echo '<a>' . ( ( $ranks > 0 ) ? ( $score / $ranks ) : '-' ) . ' / 10</a>';
         echo '<a class="num">(' . $maxRanks . ' ranked)</a>';
         echo '</div>';
         echo '<div class="i_l">';
         echo '<a><strong>Anime Rank:</strong></a>';
         echo '<a>#' . $rank2 . '</a>';
         echo '</div>';
         echo '<br>';
         echo '<div class="i_l">';
         echo '<a><strong>Anime Popularity:</strong></a>';
         echo '<a>#' . $rank . '</a>';
         echo '<a class="num">(' . $val . ' watched)</a>';
         echo '</div>';
         echo '</div>';
         echo '<div class="anime_header_info">';
         echo '<div class="info_line">';
         echo '<a><strong>Source:</strong></a>';
         echo '<a class="info" id="source">' . $record[ 'source' ] . '</a>';
         echo '</div>';
         echo '<div class="info_line">';
         echo '<a><strong>Genres:</strong></a>';
         echo '<a class="info" id="genres">' . $record[ 'genres' ] . '</a>';
         echo '</div>';
         echo '<div class="info_line">';
         echo '<a><strong>Demographic:</strong></a>';
         echo '<a class="info" id="demographic">' . $record[ 'demographic' ] . '</a>';
         echo '</div>';
         echo '</div>';
         echo '<div>';
         echo '</div>';
         echo '</div>';
         ?>
      </div>
   </div>
   <div class="body-section">
      <button id="seasons" disabled>Seasons/Episodes</button>
      <button id="synopsis">Synopsis</button>
      <button id="characters">Characters</button>
      <button id="trailers">Trailers</button>
      <button id="related">Related</button>
      <button id="reviews">Reviews</button>
   </div>
   <?php
   echo '<script src="' . $apjs . 'body-section.js"></script>';
   echo '<div class="anime-body">';
   echo '<div class="section seasons" id="seasonsSection">';

   $name = isset( $_GET[ 'link' ] ) ? $_GET[ 'link' ] : 'default';
   $query = "SELECT rom_name, image, series, season, epi_num, start_date, end_date, air_season, broadcast, producers, licensors, studios, addedScore, numOfRanks, addedWatch, mangaChaps, lnChaps, wnChaps FROM anime WHERE series = '" . $name . "' ORDER BY season";
   $result = mysqli_query( $connect1, $query );
   $totalEpiCount = 0;

   $number = 0;
   while ( $record = mysqli_fetch_assoc( $result ) ) {
      $number++;
      echo '<div class="collapsible" data-value="' . $number . '">';
      echo '<div class="collapsible-btn-wrapper">';
      echo '<button class="collapsible-btn"><strong class="season_name">' . $record[ 'season' ] . '</strong></button>';

      if ( isset( $_SESSION[ 'user' ] ) ) {
         $query3 = "SELECT epi_num, watched 
                          FROM " . $_SESSION[ 'user' ] . "
                          WHERE anime_name = '" . $record[ 'rom_name' ] . "' 
                          AND anime_season = '" . $record[ 'season' ] . "'";
         $result3 = mysqli_query( $connect3, $query3 );
         $minWatch = PHP_INT_MAX;
         mysqli_data_seek( $result3, 0 );

         echo '<div class="section-check-wrapper" data-value="' . $number . '" onclick="incrementCheck(this);">';
         echo '<button class="checkbox-btn ' . ( mysqli_num_rows( $result3 ) == $record[ 'epi_num' ] ? 'checked' : 'unchecked' ) . '" id="sectionCheck" data-romName="' . $record[ 'rom_name' ] . '" data-season="' . $record[ 'season' ] . '"></button>';

         while ( $record3 = mysqli_fetch_assoc( $result3 ) ) {
            $minWatch = min( $minWatch, $record3[ 'watched' ] );
         }
         $minWatch = ( $minWatch === PHP_INT_MAX ) ? 0 : $minWatch;
         mysqli_free_result( $result3 );

         if ( $minWatch <= 1 ) {
            echo '<p class="checkbox-text">&#10003;</p>';
         } else {
            $fontSize = ( $minWatch < 10 ) ? '25px' : ( ( $minWatch < 100 ) ? '18px' : '13px' );
            $marginTop = ( $minWatch < 10 ) ? '3px' : ( ( $minWatch < 100 ) ? '7px' : '9px' );
            echo '<p class="checkbox-text" style="font-size: ' . $fontSize . '; margin: ' . $marginTop . ' -30px;">x' . $minWatch . '</p>';
         }
         echo '</div>';
      }
      echo '</div>';
      echo '<div id="popupContainer" class="popupContainer" data-val="c">';
      echo '<div class="popup">';
      echo '<button class="popupBtn" onclick="SoptionSelected(1,' . $number . ');">Watched Again</button>';
      echo '<button class="popupBtn" onclick="SoptionSelected(2, ' . $number . ');">Watched not Again</button>';
      echo '<button class="popupBtn" onclick="SoptionSelected(3, ' . $number . ');">Not Watched</button>';
      echo '</div>';
      echo '</div>';
      echo '<div id="collapsible">';
      echo '<input type="hidden" value="' . $record[ 'season' ] . '">';
      echo '<div class="anime-left">';
      echo '<div class="anime-description">';
      echo '<div class="anime-image">';
      echo '<div class="anime-image-sub">';
      echo '<img src="' . $animeArts . $record[ 'image' ] . '" id="image" data-season="' . $record[ 'season' ] . '">';
      echo '</div>';
      echo '</div>';
      echo '<div class="info_line" style="text-align: center;">';
      echo '<a><strong></strong></a>';
      echo '<a class="info" id="season_name" data-season="' . $record[ 'season' ] . '">' . $record[ 'rom_name' ] . '</a>';
      echo '</div>';
      echo '</div>';
      echo '<div class="anime-description">';
      echo '<div class="i_l">';
      echo '<a><strong>Season Score:</strong></a>';
      if ( isset( $record[ 'addedScore' ] ) && isset( $record[ 'numOfRanks' ] ) && $record[ 'numOfRanks' ] != 0 ) {
         echo '<a class="info" id="season_score">' . ( $record[ 'addedScore' ] / $record[ 'numOfRanks' ] ) . ' / 10</a>';
      } else {
         echo '<a class="info" id="season_score">- / 10</a>';
      }
      echo '<a class="num">(' . $record[ 'numOfRanks' ] . ' ranked)</a>';
      echo '</div>';
      echo '<div class="i_l">';
      echo '<a><strong>Season Rank:</strong></a>';
      $result2 = mysqli_query( $connect1, "SELECT rom_name, season, addedScore, numOfRanks FROM anime" );
      $map2 = [];
      $map3 = [];
      while ( $record2 = mysqli_fetch_assoc( $result2 ) ) {
         if ( isset( $map2[ $record2[ 'rom_name' ] . ' ' . $record2[ 'season' ] ] ) ) {
            $map2[ $record2[ 'rom_name' ] . ' ' . $record2[ 'season' ] ] = max( $map2[ $record2[ 'rom_name' ] . ' ' . $record2[ 'season' ] ], $record2[ 'addedScore' ] );
            $map3[ $record2[ 'rom_name' ] . ' ' . $record2[ 'season' ] ] = max( $map3[ $record2[ 'rom_name' ] . ' ' . $record2[ 'season' ] ], $record2[ 'numOfRanks' ] );
         } else {
            $map2[ $record2[ 'rom_name' ] . ' ' . $record2[ 'season' ] ] = $record2[ 'addedScore' ];
            $map3[ $record2[ 'rom_name' ] . ' ' . $record2[ 'season' ] ] = $record2[ 'numOfRanks' ];
         }
      }
      mysqli_free_result( $result2 );
      $map4 = [];
      foreach ( $map2 as $key => $value ) {
         $map4[ $key ] = ( $map3[ $key ] > 0 ) ? $map2[ $key ] / $map3[ $key ] : 0;
      }
      arsort( $map4 );
      $rank2 = 1;
      foreach ( $map4 as $key => $value ) {
         if ( $value === $map4[ $record[ 'rom_name' ] . ' ' . $record[ 'season' ] ] ) {
            break;
         }
         $rank2++;
      }
      echo '<a class="info" id="season_popularity">#' . $rank2 . '</a>';
      echo '</div>';
      echo '<div class="i_l">';
      echo '<a><strong>Season Popularity:</strong></a>';
      $query4 = "SELECT addedWatch
                          FROM anime
                          ORDER BY addedWatch DESC, rom_name ASC";
      $result4 = mysqli_query( $connect1, $query4 );
      $rank = 1;
      while ( $record4 = mysqli_fetch_assoc( $result4 ) ) {
         if ( $record4[ 'addedWatch' ] === $record[ 'addedWatch' ] ) {
            break;
         }
         $rank++;
      }
      mysqli_free_result( $result4 );
      echo '<a class="info" id="season_popularity">#' . $rank . '</a>';
      echo '<a class="num">(' . $record[ 'addedWatch' ] . ' watched)</a>';
      echo '</div>';

      if ( isset( $_SESSION[ 'user' ] ) ) {
         $result3 = mysqli_query( $connect3, "SELECT season_rank, status FROM " . $_SESSION[ 'user' ] . " WHERE anime_name = '" . $record[ 'rom_name' ] . "' AND anime_season = '" . $record[ 'season' ] . "'" );
         $record3 = mysqli_fetch_assoc( $result3 );
         echo '<div class="i_l" style="display: flex;">';
         echo '<a><strong>User Score:</strong></a>';
         echo '<div class="dropdown">';
         echo '<select name="user_score" onchange="updateRank(\'' . $record[ 'rom_name' ] . '\', \'' . $record[ 'season' ] . '\', this);">';
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

         $rank = isset( $record3[ 'season_rank' ] ) ? $record3[ 'season_rank' ] : "Select Score";
         foreach ( $options as $value => $label ) {
            echo '<option value="' . $value . '" ' . ( $rank == $value ? 'selected' : '' ) . '>' . $label . '</option>';
         }
         echo '</select>';
         echo '</div>';
         echo '</div>';
         
         echo '<div class="i_l" style="display: flex;">';
         echo '<a><strong>Status:</strong></a>';
         echo '<div class="dropdown">';
         echo '<select name="user_status" onchange="updateRank(\'' . $record[ 'rom_name' ] . '\', \'' . $record[ 'season' ] . '\', this);">';
         echo '<option value="Select Score">Select Status</option>';

         $options = array(
            "Watching",
            "Completed",
            "Holding",
            "Dropped",
            "Planned"
         );

         mysqli_data_seek( $result3, 0 );
         $status = isset( $record3[ 'status' ] ) ? $record3[ 'status' ] : "Select Status";
         foreach ( $options as $value ) {
            echo '<option value="' . $value . '" ' . ( $status == $value ? 'selected' : '' ) . '>' . $value . '</option>';
         }
         echo '</select>';
         echo '</div>';
         echo '</div>';
         mysqli_free_result( $result3 );
      }
      echo '</div>';

      echo '<button class="season_info">Show Season Info</button>';
      echo '<div class="anime-description" style="display: none;">';
      echo '<div class="info_line">';
      echo '<a><strong>Start Date:</strong></a>';
      $start_date = isset( $record[ 'start_date' ] ) ? date( 'F j, Y', strtotime( $record[ 'start_date' ] ) ) : '';
      echo '<a class="info" id="start_date" data-season="' . $record[ 'season' ] . '">' . $start_date . '</a>';
      echo '</div>';
      echo '<div class="info_line">';
      echo '<a><strong>End Date:</strong></a>';
      $end_date = isset( $record[ 'end_date' ] ) ? date( 'F j, Y', strtotime( $record[ 'end_date' ] ) ) : '';
      echo '<a class="info" id="end_date" data-season="' . $record[ 'season' ] . '">' . $end_date . '</a>';
      echo '</div>';
      echo '<div class="info_line">';
      echo '<a><strong>Air Season:</strong></a>';
      echo '<a class="info" id="air_season" data-season="' . $record[ 'season' ] . '">' . $record[ 'air_season' ] . '</a>';
      echo '</div>';
      echo '<div class="info_line">';
      echo '<a><strong>Broadcast:</strong></a>';
      echo '<a class="info" id="broadcast" data-season="' . $record[ 'season' ] . '">' . $record[ 'broadcast' ] . '</a>';
      echo '</div>';
      echo '<div class="info_line" id="prods">';
      echo '<a><strong>Producer(s):</strong></a>';
      echo '<a class="info" id="producers" data-season="' . $record[ 'season' ] . '">' . $record[ 'producers' ] . '</a>';
      echo '</div>';
      echo '<div class="info_line">';
      echo '<a><strong>Licensor(s):</strong></a>';
      echo '<a class="info" id="licensors" data-season="' . $record[ 'season' ] . '">' . $record[ 'licensors' ] . '' . '</a>';
      echo '</div>';
      echo '<div class="info_line">';
      echo '<a><strong>Studio:</strong></a>';
      echo '<a class="info" id="studios" data-season="' . $record[ 'season' ] . '">' . $record[ 'studios' ] . '</a>';
      echo '</div>';
      if ( isset( $_SESSION[ 'user' ] ) && $_SESSION[ 'user' ] === $admin ) {
         echo '<div class="info_line">';
         echo '<a><strong>Manga Chapters:</strong></a>';
         echo '<a class="info" id="mangaChaps" data-season="' . $record[ 'season' ] . '">' . $record[ 'mangaChaps' ] . '</a>';
         echo '</div>';
         echo '<div class="info_line">';
         echo '<a><strong>Light Novel Chapters:</strong></a>';
         echo '<a class="info" id="lnChaps" data-season="' . $record[ 'season' ] . '">' . $record[ 'lnChaps' ] . '</a>';
         echo '</div>';
         echo '<div class="info_line">';
         echo '<a><strong>Web Novel Chapters:</strong></a>';
         echo '<a class="info" id="wnChaps" data-season="' . $record[ 'season' ] . '">' . $record[ 'wnChaps' ] . '</a>';
         echo '</div>';
      } else {
         if ( isset( $record[ 'mangaChaps' ] ) && $record[ 'mangaChaps' ] > 0 ) {
            echo '<div class="info_line">';
            echo '<a><strong>Manga Chapters:</strong></a>';
            echo '<a class="info" id="mangaChaps">Chs ' . $record[ 'mangaChaps' ] . '</a>';
            echo '</div>';
         }
         if ( isset( $record[ 'lnChaps' ] ) && $record[ 'lnChaps' ] > 0 ) {
            echo '<div class="info_line">';
            echo '<a><strong>Light Novel Chapters:</strong></a>';
            echo '<a class="info" id="lnChaps">Chs ' . $record[ 'lnChaps' ] . '</a>';
            echo '</div>';
         }
         if ( isset( $record[ 'wnChaps' ] ) && $record[ 'wnChaps' ] > 0 ) {
            echo '<div class="info_line">';
            echo '<a><strong>Web Novel Chapters:</strong></a>';
            echo '<a class="info" id="wnChaps">Chs ' . $record[ 'wnChaps' ] . '</a>';
            echo '</div>';
         }
      }
      echo '</div>';
      echo '</div>';

      echo '<div class="episode-section">';
      for ( $i = 1; $i <= $record[ 'epi_num' ]; $i++ ) {
         $totalEpiCount++;
         $query2 = "SELECT name, thumbnail, release_date
                               FROM anime 
                               WHERE anime_name = '" . $record[ 'rom_name' ] . "' 
                               AND anime_season = '" . $record[ 'season' ] . "' 
                               AND epi_num = $i";
         $result2 = mysqli_query( $connect2, $query2 ); // Find a way to make faster

         $row2 = mysqli_fetch_assoc( $result2 );
         $epi_thumbnail = isset( $row2[ 'thumbnail' ] ) ? $row2[ 'thumbnail' ] : 'default.jpg';
         $epi_name = ( !is_null( $row2 ) && $row2[ 'name' ] !== NULL ) ? $row2[ 'name' ] : 'Episode ' . $i;
         $rel_date = isset( $row2[ 'release_date' ] ) ? date( 'F j, Y', strtotime( $row2[ 'release_date' ] ) ) : '';
         mysqli_free_result( $result2 );

         echo '<div class="episode hidden" data-epiNum="' . $i . '" data-romName="' . $record[ 'rom_name' ] . '" data-season="' . $record[ 'season' ] . '" data-thumbnail="' . $episodeThumbnails . $epi_thumbnail . '" data-epiName="' . $epi_name . '" data-relDate="' . $rel_date . '" onclick="showOverlay(this);">';

         echo '<div class="episode-thumbnail">';
         echo '<img src="' . $episodeThumbnails . $epi_thumbnail . '" alt="Episode ' . $i . '">';
         echo '</div>';
         echo '<div class="episode-details">';
         echo '<div class="episode-info" id="' . $record[ 'season' ] . '">';
         echo '<h3 class="episode-title">(E' . $totalEpiCount . ') ' . $epi_name . '</h3>';
         if ( isset( $_SESSION[ 'user' ] ) ) {
            $query3 = "SELECT watched 
                          FROM " . $_SESSION[ 'user' ] . "
                          WHERE anime_name = '" . $record[ 'rom_name' ] . "' 
                          AND anime_season = '" . $record[ 'season' ] . "'
                          AND epi_num = $i";
            $result3 = mysqli_query( $connect3, $query3 );
            $row3 = mysqli_fetch_assoc( $result3 );
            $watched = isset( $row3[ 'watched' ] ) ? $row3[ 'watched' ] : 0;

            echo '<div class="check" onclick="incrementCheck(this, ' . $number . ');">';
            echo '<button class="checkbox-btn ' . ( ( $watched > 0 ) ? "checked" : "unchecked" ) . '" data-epiNum="' . $i . '" data-romName="' . $record[ 'rom_name' ] . '" data-season="' . $record[ 'season' ] . '"></button>';
            mysqli_free_result( $result3 );

            if ( $watched <= 1 ) {
               echo '<p class="checkbox-text">&#10003;</p>';
            } else {
               $fontSize = ( $watched < 10 ) ? '25px' : ( ( $watched < 100 ) ? '18px' : '13px' );
               $marginTop = ( $watched < 10 ) ? '3px' : ( ( $watched < 100 ) ? '7px' : '9px' );
               echo '<p class="checkbox-text" style="font-size: ' . $fontSize . '; margin: ' . $marginTop . ' -30px;">x' . $watched . '</p>';
            }
            echo '</div>';
         }
         echo '<input type="hidden" name="release_date" value="' . $rel_date . '">';
         echo '</div>';
         echo '</div>';
         echo '<div id="popupContainer" class="popupContainer" data-val="a">';
         echo '<div class="popup">';
         echo '<button class="popupBtn" onclick="optionSelected(4, ' . $i . ', ' . $number . ');">Check Previous?</button>';
         echo '</div>';
         echo '</div>';
         echo '<div id="popupContainer" class="popupContainer" data-val="b">';
         echo '<div class="popup">';
         echo '<button class="popupBtn" onclick="optionSelected(1, ' . $i . ', ' . $number . ');">Watched Again</button>';
         echo '<button class="popupBtn" onclick="optionSelected(2, ' . $i . ', ' . $number . ');">Watched not Again</button>';
         echo '<button class="popupBtn" onclick="optionSelected(3, ' . $i . ', ' . $number . ');">Not Watched</button>';
         echo '</div>';
         echo '</div>';
         echo '</div>';
      }
      if ( isset( $_SESSION[ 'user' ] ) && $_SESSION[ 'user' ] == $admin ) {
         echo '<div class="addEpisode" data-epiNum="' . $record[ 'epi_num' ] + 1 . '" data-val="' . $number . '" onclick="addEpisode(this);">';
         echo '<p>+</p>';
         echo '</div>';
      }
      echo '</div>';
      echo '</div>';
      echo '</div>';
   }
   mysqli_free_result( $result );
   ?>
</div>
<div class="section synopsis" hidden>
   <p>Synopsis</p>
</div>
<div class="section characters" hidden>
   <p>Characters</p>
</div>
<div class="section trailers" hidden>
   <p>Trailers</p>
</div>
<div class="section related" hidden>
   <p>Related</p>
</div>
<div class="section reviews" hidden>
   <p>Reviews</p>
</div>
</div>
<script src="../../js/animePageJS/seasonsCollapse.js"></script> 
<script src="../../js/animePageJS/addEpi.js"></script>
</div>
</div>
</div>
</div>
</div>
<?php
echo '<div id="episodeOverlay">';
echo '<div id=overlayImg>';
echo '<img>';
echo '</div>';
echo '<div id="titleLine">';
echo '<p class="overlay-content" id="title"></p>';
if ( isset( $_SESSION[ 'user' ] ) ) {
   echo '<div class="check" onclick="incCheck(this)">';
   echo '<button class="checkbox-btn unchecked" id="over"></button>';
   echo '<p class="checkbox-text">&#10003;</p>';
   echo '</div>';
   echo '<div id="popupContainer" class="popupContainer" style="position: absolute; display: none; left: 89%; margin-top: 50px;">';
   echo '<div class="popup">';
   echo '<button class="popupBtn" onclick="optSel(1);">Watched Again</button>';
   echo '<button class="popupBtn" onclick="optSel(2);">Watched not Again</button>';
   echo '<button class="popupBtn" onclick="optSel(3);">Not Watched</button>';
   echo '</div>';
   echo '</div>';
}
echo '</div>';
echo '<div id="episode-release-date">';
echo '<p>Release Date:</p>';
echo '<p id="release_date">N/A</p>';
echo '</div>';
//echo '<div id="episode-description">';
//echo '<p>Description:</p>';
//echo '<p id="description">N/A</p>';
//echo '</div>';
echo '</div>';
if ( isset( $_SESSION[ 'user' ] ) ) {
   if ( $_SESSION[ 'user' ] === $admin ) {
      echo '<script src="' . $apjs . 'editAnime.js"></script>';
      echo '<script src="' . $apjs . 'editAnimeEpi.js"></script>';
   }
}
echo '<script src="' . $apjs . 'episodeOverlay.js"></script>';
echo '<script src="' . $apjs . 'epiCheck.js"></script>';
?>
</body>
</html>