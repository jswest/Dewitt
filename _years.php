<?php
include('scripts/ci.php');
include('scripts/utility.php');
$q->connect();
$q->select_database();
$id = $_REQUEST['id'];
$year = $q->select( 'year', $id );
$year = $year[0];
?>
<h1 class="numbers"><?php echo $year['year']; ?></h1>
<?php
$pieces = $q->select_by( 'year', 'piece', $year['year'] );
foreach( $pieces as $piece ) {
  echo "<img class='year-thumb' src='" . $piece['thumb'] . "' data-title='" . $piece['title'] . "' data-year='" . $piece['year'] . "' data-materials='" . add_p_tags( $piece['materials'] ) . "'>";
}

?>