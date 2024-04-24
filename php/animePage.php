<!DOCTYPE html>
<html lang="en_US" style="background-color: #222425">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../css/animePage.css">
<link rel="stylesheet" type="text/css" href="../css/collapsable.css">
<link rel="stylesheet" type="text/css" href="../css/episode.css">
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
            $result = mysqli_query( $connect, "SELECT image FROM anime WHERE rom_name='" . $name . "'" );
            $record = mysqli_fetch_assoc( $result );

            echo '<img src="../images/arts/anime/' . $record[ 'image' ] . '" id="image">';
            mysqli_close( $connect );
            ?>
         </div>
         <div class="anime-names">
            <?php
            $connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
            $name = isset( $_GET[ 'link' ] ) ? $_GET[ 'link' ] : 'default';
            $result = mysqli_query( $connect, "SELECT eng_name, rom_name FROM anime WHERE rom_name='" . $name . "'" );
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
            $result = mysqli_query( $connect, "SELECT rom_name, image, series, season, epi_num, start_date, end_date, air_season, brodcast, producers, licensors, studios, addedScore, numOfRanks, addedWatch, mangaChaps, lnChaps, wnChaps FROM anime WHERE series = '" . $name . "' ORDER BY season" );

            $number = 0;
            while ( $record = mysqli_fetch_assoc( $result ) ) {
               $number++;
               if ( $record[ 'season' ] !== NULL ) {
                  echo '<div class="collapsible" data-value="' . $number . '">';
                  echo '<div class="collapsible-btn-wrapper">';
                  echo '<button class="collapsible-btn"><strong>' . $record[ 'season' ] . '</strong></button>';
                  if ( isset( $_SESSION[ 'user' ] ) ) {
                     echo '<div class="section-check-wrapper" data-value="' . $number . '" onclick="incrementSCheck(this);">';
                     $query = "SELECT epi_num, watched 
                          FROM " . $_SESSION[ 'user' ] . "
                          WHERE anime_name = '" . $record[ 'rom_name' ] . "' 
                          AND anime_season = '" . $record[ 'season' ] . "'";
                     $result3 = mysqli_query( $connect3, $query );
                     if ( mysqli_num_rows( $result3 ) == $record[ 'epi_num' ] ) {
                        echo '<button class="checkbox-btn checked" id="sectionCheck" data-romName="' . $record[ 'rom_name' ] . '" data-season="' . $record[ 'season' ] . '"></button>';
                     } else {
                        echo '<button class="checkbox-btn unchecked" id="sectionCheck" data-romName="' . $record[ 'rom_name' ] . '" data-season="' . $record[ 'season' ] . '"></button>';
                     }
                     $maxWatch = 0;
                     while ( $record3 = mysqli_fetch_assoc( $result3 ) ) {
                        if ( $maxWatch < $record3[ 'watched' ] ) {
                           $maxWatch = $record3[ 'watched' ];
                        }
                     }
                     if ( $maxWatch <= 1 ) {
                        echo '<p class="checkbox-text">&#10003;</p>';
                     } else if ( $maxWatch < 10 ) {
                        echo '<p class="checkbox-text" style="font-size: 25px; margin: 3px -30px;">x' . $maxWatch . '</p>';
                     } else if ( $maxWatch < 100 ) {
                        echo '<p class="checkbox-text" style="font-size: 18px; margin: 7px -30px;">x' . $maxWatch . '</p>';
                     } else if ( $maxWatch < 1000 ) {
                        echo '<p class="checkbox-text" style="font-size: 13px; margin: 9px -30px;">x' . $maxWatch . '</p>';
                     }
                     echo '</div>';
                  }
                  echo '</div>';
                  echo '<div id="SpopupContainer" class="SpopupContainer">';
                  echo '<div class="Spopup">';
                  echo '<button class="SpopupBtn" onclick="SoptionSelected(1, ' . $number . ');">Watched Again</button>';
                  echo '<button class="SpopupBtn" onclick="SoptionSelected(2, ' . $number . ');">Watched not Again</button>';
                  echo '<button class="SpopupBtn" onclick="SoptionSelected(3, ' . $number . ');">Not Watched</button>';
                  echo '</div>';
                  echo '</div>';
                  echo '<div id="collapsible">';
                  echo '<input type="hidden" value="' . $record[ 'season' ] . '">';
                  echo '<div class="anime-left">';
                  echo '<div class="anime-description">';
                  echo '<img src="../images/arts/anime/' . $record[ 'image' ] . '" id="image">';
                  echo '<div class="info_line" style="text-align: center;">';
                  echo '<a><strong></strong></a>';
                  echo '<a class="info" id="season_name" data-season="' . $record[ 'season' ] . '">' . $record[ 'rom_name' ] . '</a>';
                  echo '</div>';
                  echo '</div>';

                  $score = '-';
                  if ( isset( $record[ 'addedScore' ] ) && isset( $record[ 'numOfRanks' ] ) ) {
                     if ( $record[ 'numOfRanks' ] > 0 ) {
                        $score = $record[ 'addedScore' ] / $record[ 'numOfRanks' ];
                        $score = number_format( $score, 2 );
                     }
                  }
                  $popularity = '-';
                  if ( isset( $record[ 'addedWatch' ] ) && $record[ 'addedWatch' ] > 0 ) {
                     $resTemp = mysqli_query( $connect, "SELECT addedWatch FROM anime ORDER BY addedWatch DESC, rom_name ASC" );
                     $iTemp = 0;
                     while ( $recTemp = mysqli_fetch_assoc( $resTemp ) ) {
                        $iTemp++;
                        if ( $recTemp[ 'addedWatch' ] === $record[ 'addedWatch' ] ) {
                           $popularity = $iTemp;
                           break;
                        }
                     }
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
                     echo '<select name="user_score" onchange="updateRank(\'' . $record[ 'rom_name' ] . '\', this);">';
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
                  $start_date = '';
                  if ( $record[ 'start_date' ] !== NULL ) {
                     $start_date = new DateTime( $record[ 'start_date' ] );
                     $start_date = $start_date->format( 'F j, Y' );
                  }
                  echo '<a class="info" id="start_date" data-season="' . $record[ 'season' ] . '">' . $start_date . '</a>';
                  echo '</div>';
                  echo '<div class="info_line">';
                  echo '<a><strong>End Date:</strong></a>';
                  $end_date = '';
                  if ( $record[ 'end_date' ] !== NULL ) {
                     $end_date = new DateTime( $record[ 'end_date' ] );
                     $end_date = $end_date->format( 'F j, Y' );
                  }
                  echo '<a class="info" id="end_date" data-season="' . $record[ 'season' ] . '">' . $end_date . '</a>';
                  echo '</div>';
                  echo '<div class="info_line">';
                  echo '<a><strong>Air Season:</strong></a>';
                  echo '<a class="info" id="air_season" data-season="' . $record[ 'season' ] . '">' . $record[ 'air_season' ] . '</a>';
                  echo '</div>';
                  echo '<div class="info_line">';
                  echo '<a><strong>Brodcast:</strong></a>';
                  echo '<a class="info" id="brodcsat" data-season="' . $record[ 'season' ] . '">' . $record[ 'brodcast' ] . '</a>';
                  echo '</div>';
                  echo '<div class="info_line" id="prods">';
                  echo '<a><strong>Producer(s):</strong></a>';
                  $prods = $record[ 'producers' ];
                  if ( $prods !== NULL ) {
                     while ( strpos( $prods, ',' ) !== false ) {
                        echo '<a class="info" id="producers" data-season="' . $record[ 'season' ] . '">' . substr( $prods, 0, strpos( $prods, ',' ) + 2 ) . '</a>';
                        $prods = substr( $prods, strpos( $prods, ',' ) + 2 );
                     }
                  }
                  echo '<a class="info" id="producers" data-season="' . $record[ 'season' ] . '">' . $prods . '</a>';
                  echo '</div>';
                  echo '<div class="info_line">';
                  echo '<a><strong>Licensor(s):</strong></a>';
                  echo '<a class="info" id="licensors" data-season="' . $record[ 'season' ] . '">' . $record[ 'licensors' ] . '' . '</a>';
                  echo '</div>';
                  echo '<div class="info_line">';
                  echo '<a><strong>Studio:</strong></a>';
                  echo '<a class="info" id="studios" data-season="' . $record[ 'season' ] . '">' . $record[ 'studios' ] . '</a>';
                  echo '</div>';
                  if ( isset( $_SESSION[ 'user' ] ) && $_SESSION[ 'user' ] === 'oracle' ) {
                     $mCs = isset( $record[ 'mangaChaps' ] ) ? $record[ 'mangaChaps' ] : '-';
                     $lnCs = isset( $record[ 'lnChaps' ] ) ? $record[ 'lnChaps' ] : '-';
                     $wnCs = isset( $record[ 'wnChaps' ] ) ? $record[ 'wnChaps' ] : '-';
                     echo '<div class="info_line">';
                     echo '<a><strong>Manga Chapters:</strong></a>';
                     echo '<a class="info" id="mangaChaps" data-season="' . $record[ 'season' ] . '">' . $mCs . '</a>';
                     echo '</div>';
                     echo '<div class="info_line">';
                     echo '<a><strong>Light Novel Chapters:</strong></a>';
                     echo '<a class="info" id="lnChaps" data-season="' . $record[ 'season' ] . '">' . $lnCs . '</a>';
                     echo '</div>';
                     echo '<div class="info_line">';
                     echo '<a><strong>Web Novel Chapters:</strong></a>';
                     echo '<a class="info" id="wnChaps" data-season="' . $record[ 'season' ] . '">' . $wnCs . '</a>';
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

                  $result2 = mysqli_query( $connect2, "SELECT name, thumbnail, release_date
                  FROM anime 
                  WHERE anime_series = '" . $name . "' 
                  AND anime_season = '" . $record[ 'season' ] . "' 
                  ORDER BY epi_num" );
                  echo '<div class="episode-section">';
                  for ( $i = 1; $i <= $record[ 'epi_num' ]; $i++ ) {
                     $record2 = mysqli_fetch_assoc( $result2 );
                     $thumbnail = 'default.jpg';
                     if ( isset( $record2[ 'thumbnail' ] ) ) {
                        $thumbnail = $record2[ 'thumbnail' ];
                     }

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

                     $rel_date = '';
                     if ( isset( $record2[ 'release_date' ] ) ) {
                        $rel_date = new DateTime( $record2[ 'release_date' ] );
                        $rel_date = $rel_date->format( 'F j, Y' );
                     }

                     echo '<div class="episode hidden" data-epiNum="' . $i . '" data-romName="' . $record[ 'rom_name' ] . '" data-season="' . $record[ 'season' ] . '" data-thumbnail="../images/episodes/anime/' . $thumbnail . '" data-epiName="' . $epi_name . '" data-relDate="' . $rel_date . '" onclick="showOverlay(this);">';

                     echo '<div class="episode-thumbnail">';
                     echo '<img src="../images/episodes/anime/' . $thumbnail . '" alt="Episode ' . $i . '">';
                     echo '</div>';
                     echo '<div class="episode-details">';
                     echo '<div class="episode-info" id="' . $record[ 'season' ] . '">';
                     echo '<h3 class="episode-title">' . $epi_name . '</h3>';
                     if ( isset( $_SESSION[ 'user' ] ) ) {
                        $query = "SELECT epi_num, watched 
                          FROM " . $_SESSION[ 'user' ] . "
                          WHERE anime_name = '" . $record[ 'rom_name' ] . "' 
                          AND anime_season = '" . $record[ 'season' ] . "'";
                        $result3 = mysqli_query( $connect3, $query );
                        echo '<div class="check" onclick="incrementCheck(this, ' . $number . ');">';
                        $watched = 0;
                        while ( $record3 = mysqli_fetch_assoc( $result3 ) ) {
                           if ( $record3[ 'epi_num' ] == $i ) {
                              echo '<button class="checkbox-btn checked" data-epiNum="' . $i . '" data-romName="' . $record[ 'rom_name' ] . '" data-season="' . $record[ 'season' ] . '"></button>';
                              $watched = $record3[ 'watched' ];
                           }
                        }
                        if ( $watched === 0 ) {
                           echo '<button class="checkbox-btn unchecked" data-epiNum="' . $i . '" data-romName="' . $record[ 'rom_name' ] . '" data-season="' . $record[ 'season' ] . '"></button>';
                        }
                        if ( $watched <= 1 ) {
                           echo '<p class="checkbox-text">&#10003;</p>';
                        } else if ( $watched < 10 ) {
                           echo '<p class="checkbox-text" style="font-size: 25px; margin: 3px -30px;">x' . $watched . '</p>';
                        } else if ( $watched < 100 ) {
                           echo '<p class="checkbox-text" style="font-size: 18px; margin: 7px -30px;">x' . $watched . '</p>';
                        } else if ( $watched < 1000 ) {
                           echo '<p class="checkbox-text" style="font-size: 13px; margin: 9px -30px;">x' . $watched . '</p>';
                        }
                        echo '</div>';
                     }
                     echo '<input type="hidden" name="release_date" value="' . $rel_date . '">';
                     echo '</div>';
                     echo '</div>';
                     echo '<div id="popupContainer" class="popupContainer">';
                     echo '<div class="popup">';
                     echo '<button class="popupBtn" onclick="optionSelected(1, ' . $i . ', ' . $number . ');">Watched Again</button>';
                     echo '<button class="popupBtn" onclick="optionSelected(2, ' . $i . ', ' . $number . ');">Watched not Again</button>';
                     echo '<button class="popupBtn" onclick="optionSelected(3, ' . $i . ', ' . $number . ');">Not Watched</button>';
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
</body>
</html>