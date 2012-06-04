<?php
include( "../scripts/ci.php" );
$q->connect();
$q->select_database();
$password = md5( $_POST['password'] );
echo $password;
$values = array( 'password' => $password );
$q->create( 'password', $values );
$q->disconnect();
header( "Location: ../admin" );
?>