<?php
function add_p_tags( $s ){
  return str_replace( "\n", "</p><p>", $s );
}
function check_to_include_in_display( $name ) {
  $bad_names = array(
    'createdAt',
    'updatedAt',
    'bg',
    'src',
    'blurb',
    'example',
    'thumb'
  );
  $include = true;
  foreach( $bad_names as $bad_name ) {
    if( $name == $bad_name ){
      $include = false;
    }
  }
  return $include;
}

function check_to_include_in_action( $name ) {
  $bad_names = array(
    'createdAt',
    'updatedAt',
  );
  $include = true;
  foreach( $bad_names as $bad_name ) {
    if( $name == $bad_name ){
      $include = false;
    }
  }
  return $include;
}

?>