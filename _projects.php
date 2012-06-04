<?php
include('scripts/ci.php');
include('scripts/utility.php');
$q->connect();
$q->select_database();
$id = $_REQUEST['id'];
$project = $q->select( 'project', $id );
$project = $project[0];
?>

<h1><?php echo $project['title']; ?></h1>
<?php
if( $project['example'] ) {
  echo "<img class='example' src=" . $project['example'] . ">";
} 
?>
<div id="blurb">
  <p><?php echo add_p_tags( $project['blurb'] ); ?></p>
</div>

