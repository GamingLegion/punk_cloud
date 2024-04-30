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
         $query = "SELECT username, icon FROM users WHERE username = '" . $_SESSION[ 'user' ] . "'";
         $result = mysqli_query( $connect1, $query );
         $record = mysqli_fetch_assoc( $result );
         echo '<a class="username">' . $record[ 'username' ] . '</a>';
         echo '<img class="userIcon" src="' . $userIcons . $record[ 'icon' ] . '" alt="User Icon">';
         ?>
      </div>
      <div class="lists">
         <div class="list allLists">
            <p>All Lists</p>
            <?php
            $result = mysqli_query( $connect1, 'Select eng_name, rom_name, image, series FROM anime ORDER BY ins_date DESC LIMIT 9' );

            while ( $record = mysqli_fetch_assoc( $result ) ) {
               echo '<div class="aniCard" id="card" width="50%">';
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
            ?>
         </div>
         <div class="filmLists">
            <div class="list anime">
               <p>Anime List</p>
               <?php
               $last = array();
               $result = mysqli_query( $connect3, "SELECT anime_name, anime_season FROM " . $_SESSION[ 'user' ] . " ORDER BY ins_date DESC" );
               while ( $record = mysqli_fetch_assoc( $result ) ) {
                  if(count($last) >= 4) {
                     break;
                  }
                  if ( !in_array($record[ 'anime_name' ] . ' ' . $record[ 'anime_season' ], $last) ) {
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

                     array_push($last, $record[ 'anime_name' ] . ' ' . $record[ 'anime_season' ]);
                  }
               }
               ?>
            </div>
            <div class="list liveaction">
               <p>Live Action List</p>
            </div>
            <div class="list cartoon">
               <p>Cartoon List</p>
            </div>
         </div>
         <div class="textLists">
            <div class="list novel">
               <p>Novel List</p>
            </div>
            <div class="list comic">
               <p>Comic List</p>
            </div>
            <div class="list manga">
               <p>Manga List</p>
            </div>
            <div class="list manhwa">
               <p>Manhwa List</p>
            </div>
            <div class="list manhua">
               <p>Manhua List</p>
            </div>
            <div class="list lightnovel">
               <p>Light Novel List</p>
            </div>
            <div class="list webnovel">
               <p>Web Novel List</p>
            </div>
         </div>
      </div>
      <?php
      echo '<script src="' . $js . 'pageClick.js"></script>';
      ?>
   </div>
</div>
</body>
</html>