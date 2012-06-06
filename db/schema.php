<?php

include('../scripts/ci.php');
  
// CONNECT TO MYSQL
$q->connect();

// CREATE THE DATABASE
$q->create_database();

// PASSWORDS
$q->create_table(
  'passwords',
  array(
    'password' => 'varchar(255)'
  )
);


// PIECES
$q->create_table(
  'pieces',
  array(
    'title' => 'varchar(255)',
    'materials' => 'text',
    'src' => 'varchar(255)',
    'thumb' => 'varchar(255)',
    'year' => 'varchar(4)'     
  )
);

// YEARS
$q->create_table(
  'years',
  array(
    'year' => 'varchar(4)'
  )
);

// PAGES
$q->create_table(
  'pages',
  array(
    'title' => 'varchar(255)',
    'blurb' => 'text'
  )
);

// PROJECTS
$q->create_table(
  'projects',
  array(
    'title' => 'varchar(255)',
    'blurb' => 'text',
    'example' => 'varchar(255)',
  )
);

// BACKGROUNDS
$q->create_table(
  'backgrounds',
  array(
    'title' => 'varchar(255)',
    'bg' => 'varchar(255)'
  )
);

?>