<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Header Bar</title>
<link rel="stylesheet" type="text/css" href="../css/header.css">

<div class="headerBar">
   <div class="searchCats"> <a href="home.php"><img src="../images/icons/logo.png" alt="PunkCloud Logo" class="homeBtn"></a> </div>
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
            <option value="movels" data-value="nd" disabled>Novels</option>
            <option value="mangas" data-value="nd" disabled>Manga</option>
            <option value="manwhas" data-value="nd" disabled>Manwha</option>
            <option value="manhua" data-value="nd" disabled>Manhua</option>
            <option value="light_novels" data-value="nd" disabled>Light Novel</option>
            <option value="web_novels" data-value="nd" disabled>Web Novel</option>
            </optgroup>
         </select>
      </div>
      <div class="search-container">
         <input type="text" class="search-input" placeholder="Search anime...">
         <div class="search-results">
            <ul id="searchResults">
            </ul>
         </div>
      </div>
   </div>
   <script src="../js/multiSearch.js"></script>
   <div class="userOpts">
      <?php
      $connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );

      if ( isset( $_SESSION[ 'user' ] ) ) {
         if ( $_SESSION[ 'user' ] === 'oracle' ) {
            echo '<a href="addEntry.php"><img src="../images/icons/addEntry_icon.png" alt="PunkCloud Logo" class="addEntryBtn"></a>';
         }
         $result = mysqli_query( $connect, "Select icon FROM users WHERE username = '" . $_SESSION[ 'user' ] . "' " );
         $record = mysqli_fetch_assoc( $result );
         echo '<a href="userPage.php"><img src="../images/users/' . $record[ 'icon' ] . '" alt="User" class="loginBtn"></a>';
      } else {
         echo '<a href="login.php"><img src="../images/icons/login_icon.png" alt="Login" class="loginBtn"></a>';
      }
      ?>
   </div>
</div>
</head>
</html>
