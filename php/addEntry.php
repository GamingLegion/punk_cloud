<!DOCTYPE html>
<html lang="en_US" style="background-color: #222425">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../css/addEntry.css">
<title>Add Entry</title>

<?php
$IPATH = $_SERVER[ "DOCUMENT_ROOT" ] . "/PunkCloud/php/components/";
include( $IPATH . "header.html" );
?>
</head>
<body>
<div class="container">
   <h1>Add Entry</h1>
   <form action="tools/insertEntry.php" method="post" id="form">
      <div class="form-group">
         <label>English Name: </label>
         <input type="text" name="eng_name">
      </div>
      <div class="form-group">
         <label>Romanized Name: </label>
         <input type="text" name="rom_name" required>
      </div>
      <div class="form-group">
         <label>Entry Type: </label>
         <select name="entry_type" required>
            <option></option>
            <option value="usa_la_shows">American Live-Action Show</option>
            <option value="usa_la_movies">American Live-Action Movie</option>
            <option value="usa_cartoon_shows">American Cartoon Show</option>
            <option value="usa_cartoon_movies">American Cartoon Movie</option>
            <option value="anime_shows">Anime Show</option>
            <option value="anime_movies">Anime Movie</option>
            <option value="anime_onas">Anime ONA</option>
         </select>
      </div>
      <div class="form-group">
         <label>Series Image: </label>
         <input type="file" name="image">
      </div>
      <br>
      <button type="submit" name="submit">Submit</button>
   </form>
</div>
</body>
</html>