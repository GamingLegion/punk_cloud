<?php
$admin = 'oracle';

$connect1 = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );
$connect2 = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud_episodes' );
$connect3 = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud_users' );

$css = "/PunkCloud/css/";
$js = "/PunkCloud/js/";
$tools = "/PunkCloud/php/tools/";
$pages = "/PunkCloud/php/pages/";
$adminPages = "/PunkCloud/php/adminPages/";

$header = $_SERVER[ "DOCUMENT_ROOT" ] . "/PunkCloud/php/components/header.php";
$animeArts = '/PunkCloud/images/arts/anime/';
$episodeThumbnails = '/PunkCloud/images/episodes/anime/';
$icons = '/PunkCloud/images/icons/';
$userIcons = '/PunkCloud/images/users/';
?>