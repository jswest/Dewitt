<?php
include( "../scripts/access.php" );
$q->connect();
$q->select_database();

$table = $_GET['table'];
$table_single = rtrim( $table, 's' );
$id = $_GET['id'];

$q->destroy( $table_single, $id );
$q->disconnect();
header( "Location: ../admin" );

?>