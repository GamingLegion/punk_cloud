<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Entry Page</title>
   
<?php
$IPATH = $_SERVER[ "DOCUMENT_ROOT" ] . "/PunkCloud/php/components/";
include( $IPATH . "header.html" );
?>
</head>
<body>
<?php

$linkName = isset( $_GET[ 'link' ] ) ? $_GET[ 'link' ] : 'default';
echo '<p>' . $linkName . '</p>';
?>
</body>
</html>