<?php
$connect = mysqli_connect( 'localhost', 'root', 'theallseeingeyes', 'punkcloud' );

$data = json_decode( file_get_contents( 'php://input' ), true );
$name = $data[ 'name' ];
$field = $data[ 'field' ];
$value = $data[ 'value' ];

if($field === 'dob') {
   $value = date("Y-m-d", strtotime($value));;
}

mysqli_query( $connect, "UPDATE models SET $field = '$value' WHERE name = '$name'" );
mysqli_close( $connect );
?>