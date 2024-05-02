<!DOCTYPE html>
<html lang="en_US" style="background-color: #222425">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Page</title>
<?php
session_start();
include '../globalVars.php';

if ( isset( $_SESSION[ 'user' ] ) ) {
   echo '<link rel="stylesheet" type="text/css" href="' . $css . 'userPage.css">';
   echo '<link rel="stylesheet" type="text/css" href="' . $css . 'smallerCard.css">';
   include( $header );
} else {
   header( "Location: http://localhost/PunkCloud/php/pages/login.php" );
}
?>
</head>
<body>
<div class="container">
   <?php
   echo '<form action="' . $tools . 'signout.php" method="post">';
   echo '<div class="signout">';
   echo '<button type="signout">Sign Out</button>';
   echo '</div>';
   echo '</form>';
   ?>
   <div class="account">
      <div class="info">
         <?php
         $result = mysqli_query( $connect1, "SELECT icon FROM users WHERE username = '" . $_SESSION[ 'user' ] . "'" );
         $record = mysqli_fetch_assoc( $result );
         echo '<a class="username">' . $_SESSION[ 'user' ] . '</a>';
         echo '<div class="userIcon">';
         echo '<img  src="' . $userIcons . $record[ 'icon' ] . '" alt="User Icon">';
         echo '</div>';
         ?>
      </div>
      <div class="lists">
         <div class="list allLists">
            <p class="listName">All Lists</p>
            <div class="listCards">
               <?php
               $last = array();
               $result = mysqli_query( $connect3, "SELECT anime_name, anime_season FROM " . $_SESSION[ 'user' ] . " ORDER BY ins_date DESC" );
               while ( $record = mysqli_fetch_assoc( $result ) ) {
                  if ( count( $last ) >= 5 ) {
                     break;
                  }
                  if ( !in_array( $record[ 'anime_name' ] . ' ' . $record[ 'anime_season' ], $last ) ) {
                     $result2 = mysqli_query( $connect1, "SELECT image, rom_name, eng_name, series FROM anime WHERE rom_name = '" . $record[ 'anime_name' ] . "' AND season = '" . $record[ 'anime_season' ] . "'" );
                     $record2 = mysqli_fetch_assoc( $result2 );
                     echo '<div class="aniCard" id="card" width="50%">';
                     echo '<div id="thumbnail">';
                     echo '<img src="' . $animeArts . $record2[ 'image' ] . '" alt="' . $record2[ 'rom_name' ] . '">';
                     echo '<div class="title">';
                     if ( $record2[ 'eng_name' ] != NULL ) {
                        echo '<p title="' . $record2[ 'series' ] . '">' . $record2[ 'eng_name' ] . '</p>';
                     } else {
                        echo '<p title="' . $record2[ 'series' ] . '">' . $record2[ 'rom_name' ] . '</p>';
                     }
                     echo '</div>';
                     echo '</div>';
                     echo '</div>';

                     array_push( $last, $record[ 'anime_name' ] . ' ' . $record[ 'anime_season' ] );
                  }
               }
               ?>
            </div>
         </div>
         <div class="filmLists">
            <div class="list anime">
               <p class="listName">Anime List</p>
               <div class="listCards">
                  <?php
                  $last = array();
                  $result = mysqli_query( $connect3, "SELECT anime_name, anime_season FROM " . $_SESSION[ 'user' ] . " ORDER BY ins_date DESC" );
                  while ( $record = mysqli_fetch_assoc( $result ) ) {
                     if ( count( $last ) >= 5 ) {
                        break;
                     }
                     if ( !in_array( $record[ 'anime_name' ] . ' ' . $record[ 'anime_season' ], $last ) ) {
                        $result2 = mysqli_query( $connect1, "SELECT image, rom_name, eng_name, series FROM anime WHERE rom_name = '" . $record[ 'anime_name' ] . "' AND season = '" . $record[ 'anime_season' ] . "'" );
                        $record2 = mysqli_fetch_assoc( $result2 );
                        echo '<div class="aniCard" id="card" width="50%">';
                        echo '<div id="thumbnail">';
                        echo '<img src="' . $animeArts . $record2[ 'image' ] . '" alt="' . $record2[ 'rom_name' ] . '">';
                        echo '<div class="title">';
                        if ( $record2[ 'eng_name' ] != NULL ) {
                           echo '<p title="' . $record2[ 'series' ] . '">' . $record2[ 'eng_name' ] . '</p>';
                        } else {
                           echo '<p title="' . $record2[ 'series' ] . '">' . $record2[ 'rom_name' ] . '</p>';
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';

                        array_push( $last, $record[ 'anime_name' ] . ' ' . $record[ 'anime_season' ] );
                     }
                  }
                  ?>
               </div>
            </div>
            <div class="list liveaction">
               <p class="listName">Live Action List</p>
               <div class="listCards"> </div>
            </div>
            <div class="list cartoon">
               <p class="listName">Cartoon List</p>
               <div class="listCards"> </div>
            </div>
         </div>
         <br><br><br>
         <div class="textLists">
            <div class="list novel">
               <p class="listName">Novel List</p>
               <div class="listCards"> </div>
            </div>
            <div class="list comic">
               <p class="listName">Comic List</p>
               <div class="listCards"> </div>
            </div>
            <div class="list manga">
               <p class="listName">Manga List</p>
               <div class="listCards"> </div>
            </div>
            <div class="list manhwa">
               <p class="listName">Manhwa List</p>
               <div class="listCards"> </div>
            </div>
            <div class="list manhua">
               <p class="listName">Manhua List</p>
               <div class="listCards"> </div>
            </div>
            <div class="list lightnovel">
               <p class="listName">Light Novel List</p>
               <div class="listCards"> </div>
            </div>
            <div class="list webnovel">
               <p class="listName">Web Novel List</p>
               <div class="listCards"> </div>
            </div>
         </div>
      <br>
      </div>
      <?php
      echo '<script src="' . $js . 'pageClick.js"></script>';
      ?>
   </div>
</div>
</body>
</html>