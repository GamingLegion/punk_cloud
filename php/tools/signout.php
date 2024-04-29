<?php
session_start();
unset( $_SESSION[ 'user' ] );
header( "Location: http://localhost/PunkCloud/php/pages/login.php" );
exit();
?>