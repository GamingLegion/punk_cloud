<!DOCTYPE html>
<html lang="en_US" style="background-color: #222425">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../css/addEntry.css">
<title>Add Entry</title>
<?php
session_start();
$IPATH = $_SERVER[ "DOCUMENT_ROOT" ] . "/PunkCloud/php/components/";
include( $IPATH . "header.html" );
?>
</head>
<body>
<div class="container">
   <h1>Add Entry</h1>
   <form action="tools/insertEntry.php" method="post" id="form">
      <div class="form-group">
         <label>Romanized Name: </label>
         <input type="text" name="rom_name" required>
      </div>
      <div class="form-group">
         <label>English Name: </label>
         <input type="text" name="eng_name">
      </div>
      <div class="form-group">
         <label>Anime Image: </label>
         <input type="file" name="image">
      </div>
      <div class="form-group">
         <label>Number of Episodes: </label>
         <input type="number" name="epis">
      </div>
      <div class="form-group">
         <label>Series Name: </label>
         <input type="text" name="series" required>
      </div>
      <div class="form-group">
         <label>Season/Arc: </label>
         <input type="text" name="season" required>
      </div>
      <br>
      <button type="submit" name="submit">Submit</button>
   </form>
</div>
</body>
</html>