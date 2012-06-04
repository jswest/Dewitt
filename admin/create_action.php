<?php
ini_set( 'memory_limit', '80M' );
include( "../scripts/access.php" );
include('../scripts/Resize.php');
$q->connect();
$q->select_database();

$table_single = $_POST['table'];
$table = $table_single . "s";

if( $table_single == 'background' ) {
  move_uploaded_file( $_FILES["bg"]["tmp_name"], "../images/" . $_FILES["bg"]["name"]);
  $src = "images/" . $_FILES["bg"]["name"];
  $values = array(
    'title' => $_POST['title'],
    'bg' => $src
  );
  $q->create( $table_single, $values );

} elseif( $table_single == 'page' ) {
  $values = array(
    'title' => $_POST['title'],
    'blurb' => $_POST['blurb']
  );
  $q->create( $table_single, $values );

} elseif( $table_single == 'project' ) {
  move_uploaded_file( $_FILES["example"]["tmp_name"], "../images/" . $_FILES["example"]["name"]);
  $thumb = "../images/" . $_FILES["example"]["name"];
  $r = new Resize( $thumb );
  $r->create_project_thumb();
  $r->save_image( "../images/project_thumb_" . $_FILES["example"]["name"] );
  $thumb = "images/example_thumb_" . $_FILES["example"]["name"];
  $example = "../images/" . $_FILES["example"]["name"];
  $r = new Resize( $example );
  $r->create_piece();
  $r->save_image( "../images/example_" . $_FILES["example"]["name"] );
  $example = "images/example_" . $_FILES["example"]["name"];
  $values = array(
    'title' => $_POST['title'],
    'blurb' => $_POST['blurb'],
    'example' => $example
  );
  $q->create( $table_single, $values );
  
} elseif( $table_single == 'piece' ) {
  move_uploaded_file( $_FILES["src"]["tmp_name"], "../images/" . $_FILES["src"]["name"]);
  $src = "../images/" . $_FILES["src"]["name"];
  $r = new Resize( $src );
  $r->create_piece();
  $r->save_image( "../images/resized_" . $_FILES["src"]["name"] );
  $src = "images/resized_" . $_FILES["src"]["name"];
  $thumb = "../images/" . $_FILES["src"]["name"];
  $r = new Resize( $thumb );
  $r->create_thumb();
  $r->save_image( "../images/thumb_" . $_FILES["src"]["name"] );
  $thumb = "images/thumb_" . $_FILES["src"]["name"];
  $values = array(
    'title' => $_POST['title'],
    'materials' => $_POST['materials'],
    'src' => $src,
    'thumb' => $thumb,
    'year' => $_POST['year']
  );
  $q->create( $table_single, $values );

} elseif( $table_single == 'year' ) {
  $values = array(
    'year' => $_POST['year']
  );
  $q->create( $table_single, $values );

} else {
  echo "something has gone very, very wrong";
}



$q->disconnect();
header( "Location: ../admin/create.php?table=$table" );
?>