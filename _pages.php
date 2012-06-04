<?php
include('scripts/ci.php');
include('scripts/utility.php');
$q->connect();
$q->select_database();
$id = $_REQUEST['id'];
$page = $q->select( 'page', $id );
$page = $page[0];
?>

<h1><?php echo $page['title']; ?></h1>
<div id="blurb">
  <p><?php echo add_p_tags( $page['blurb'] ); ?></p>
</div>

