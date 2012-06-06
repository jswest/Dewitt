<?php
ini_set( 'memory_limit', '80M' );
include( "../scripts/access.php" );
include('../scripts/Resize.php');
$q->connect();
$q->select_database();

$table_single = $_POST['table'];
$id = $_POST['id'];
$table = $table_single . "s";

if( $table_single == 'background' ) {
  move_uploaded_file( $_FILES["bg"]["tmp_name"], "../images/" . $_FILES["bg"]["name"]);
  $src = "images/" . $_FILES["bg"]["name"];
  $values = array(
    'title' => $_POST['title'],
    'bg' => $src
  );
  $q->update( $table_single, $id, $values );

} elseif( $table_single == 'page' ) {
  $values = array(
    'title' => $_POST['title'],
    'blurb' => $_POST['blurb']
  );
  $q->update( $table_single, $id, $values );

} elseif( $table_single == 'project' ) {
  move_uploaded_file( $_FILES["example"]["tmp_name"], "../images/" . $_FILES["example"]["name"]);
  $thumb = "../images/" . $_FILES["example"]["name"];
  $r = new Resize( $thumb );
  $r->create_thumb( 200 );
  $thumb = ltrim( $r->final_path, '../' );
  $example = "../images/" . $_FILES["example"]["name"];

  $values = array(
    'title' => $_POST['title'],
    'blurb' => $_POST['blurb'],
    'example' => $example
  );
  $q->update( $table_single, $id, $values );
  
} elseif( $table_single == 'piece' ) {
  move_uploaded_file( $_FILES["src"]["tmp_name"], "../images/" . $_FILES["src"]["name"]);
  $src = "../images/" . $_FILES["src"]["name"];

  $thumb = "../images/" . $_FILES["src"]["name"];
  $r = new Resize( $thumb );
  $r->create_thumb( 100 );
  $thumb = ltrim( $r->final_path, '../' );
  $values = array(
    'title' => $_POST['title'],
    'materials' => $_POST['materials'],
    'src' => $src,
    'thumb' => $thumb,
    'year' => $_POST['year']
  );
  $q->update( $table_single, $id, $values );

} elseif( $table_single == 'year' ) {
  $values = array(
    'year' => $_POST['year']
  );
  $q->update( $table_single, $id, $values );

} else {
  echo "something has gone very, very wrong";
}



$q->disconnect();
header( "Location: ../admin/" );
?>