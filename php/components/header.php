<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Header Bar</title>
<?php
include '../globalVars.php';
echo '<link rel="stylesheet" type="text/css" href="' . $css . 'header.css">';
echo '<link rel="stylesheet" type="text/css" href="' . $fonts . '">';
?>

<div class="headerBar">
   <?php
   echo '<div class="searchCats"> <a href="' . $pages . 'home.php"><img src="' . $icons . 'logo.png" alt="PunkCloud Logo" class="homeBtn"></a> </div>';
   ?>
   <div class="searchBar">
      <div class="filter-container">
         <select id="searchFilter">
            <optgroup label="">
            <option value="all" data-value="d">All</option>
            </optgroup>
            <optgroup label="TV/Movies">
            <option value="anime" data-value="d">Anime</option>
            <option value="live_action" data-value="nd" disabled>Live-Action</option>
            <option value="cartoons" data-value="nd" disabled>Cartoons / Other Animated</option>
            </optgroup>
            <optgroup label="Books/Novels">
            <option value="novels" data-value="nd" disabled>Novels</option>
            <option value="comics" data-value="nd" disabled>Comics</option>
            <option value="mangas" data-value="nd" disabled>Manga</option>
            <option value="manhwas" data-value="nd" disabled>Manhwa</option>
            <option value="manhua" data-value="nd" disabled>Manhua</option>
            <option value="light_novels" data-value="nd" disabled>Light Novel</option>
            <option value="web_novels" data-value="nd" disabled>Web Novel</option>
            </optgroup>
         </select>
      </div>
      <div class="search-container">
         <input type="text" class="search-input" placeholder="Search...">
         <div class="search-results">
            <ul id="searchResults">
            </ul>
         </div>
      </div>
   </div>
   <?php
   echo '<script src="' . $js . 'multiSearch.js"></script>';
   echo '<div class="userOpts">';
   if ( isset( $_SESSION[ 'user' ] ) ) {
      if ( $_SESSION[ 'user' ] === $admin ) {
         echo '<a href="' . $adminPages . 'addEntry.php"><img src="' . $icons . 'addEntry_icon.png" alt="PunkCloud Logo" class="addEntryBtn"></a>';
      }
      $result = mysqli_query( $connect1, "Select icon FROM users WHERE username = '" . $_SESSION[ 'user' ] . "' " );
      $record = mysqli_fetch_assoc( $result );
      echo '<a href="' . $pages . 'userPage.php"><img src="' . $userIcons . $record[ 'icon' ] . '" alt="User" class="loginBtn"></a>';
   } else {
      echo '<a href="' . $pages . 'login.php"><img src="' . $icons . 'login_icon.png" alt="Login" class="loginBtn"></a>';
   }
   echo '</div>';
   ?>
</div>
</head>
</html>
