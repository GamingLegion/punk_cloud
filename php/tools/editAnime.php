<?php
include '../globalVars.php';
$data = json_decode( file_get_contents( 'php://input' ), true );
date_default_timezone_set( 'America/New_York' );

$upd_date = date( "Y-m-d H:i:s" );
$name = mysqli_real_escape_string($connect1, $data['name']);
$season = mysqli_real_escape_string($connect1, $data['season']);
$field = mysqli_real_escape_string($connect1, $data['field']);
$value = mysqli_real_escape_string($connect1, $data['value']);

if ( $field == 'start_date' || $field == 'end_date' ) {
   $value = date( "Y-m-d", strtotime( $value ) );
}

if($value == '' || $value == NULL) {
   $updateStmt = mysqli_prepare($connect1, "UPDATE anime SET $field = NULL, upd_date = ? WHERE rom_name = ? AND season = ?");
   mysqli_stmt_bind_param($updateStmt, 'sss', $upd_date, $name, $season);
   mysqli_stmt_execute($updateStmt);
   mysqli_stmt_close($updateStmt);
} else {
   $updateStmt = mysqli_prepare($connect1, "UPDATE anime SET $field = ?, upd_date = ? WHERE rom_name = ? AND season = ?");
   mysqli_stmt_bind_param($updateStmt, 'ssss', $value, $upd_date, $name, $season);
   mysqli_stmt_execute($updateStmt);
   mysqli_stmt_close($updateStmt);
}
if($field == 'season') {
    $updateStmt2 = mysqli_prepare($connect2, "UPDATE anime SET anime_season = ? WHERE anime_name = ? AND anime_season = ?");
    mysqli_stmt_bind_param($updateStmt2, 'sss', $value, $name, $season);
    mysqli_stmt_execute($updateStmt2);
    mysqli_stmt_close($updateStmt2);
}
?>