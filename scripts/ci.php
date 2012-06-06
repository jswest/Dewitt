<?php

include('SQLQuery.php');

$ci = array(
  'servername' => 'localhost',
  'username' => 'root',
  'password' => 'root',
  'db_name' => 'dewitt'
);

$q = new SQLQuery();
$q->set_ci( $ci );

?>