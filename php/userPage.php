<!DOCTYPE html>
<html lang="en_US" style="background-color: #222425">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../css/userPage.css">
<title>User Page</title>
<?php
session_start();
$IPATH = $_SERVER[ "DOCUMENT_ROOT" ] . "/PunkCloud/php/components/";
include( $IPATH . "header.php" );
?>
</head>
<body>
<div class="container">
   <button id="signout">Sign Out</button>
</div>
<script src="../js/signout.js"></script>
</body>
</html>