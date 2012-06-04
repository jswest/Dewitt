<?php

class SQLQuery {
  
  // INSTANCE VARIABLES
  var $connection;
  var $ci;
  
  function set_ci( $ci_array ) {
    $this->ci = $ci_array;
  }

  // THE CONNECT FUNCTION
  function connect() {
    $this->connection = mysql_connect( $this->ci['servername'], $this->ci['username'], $this->ci['password'] );
    if( !$this->connection ) {
      die( 'did not connect: ' . mysql_error() );
    }
  }
  

  // THE DISCONNECT FUNCITON
  function disconnect() {
    mysql_close( $this->connection );
  }
  

  // CREATE THE DATABASE
  function create_database(){
    $qs = "CREATE DATABASE " . $this->ci['db_name'];
    $db_create = mysql_query( $qs );
    if( !$db_create ) {
      die( 'Database creation FAIL: ' . mysql_error() );
    } else {
      echo "Database created!";
    }
  }
  
  // SELECT THE DATABASE
  function select_database(){
    mysql_select_db( $this->ci['db_name'], $this->connection );
  }
  

  // CREATE A TABLE
  function create_table( $table, $columns ) {
    $this->select_database();
    $query_string = "CREATE TABLE $table(";
    $table_single = rtrim( $table, 's' );
    $query_string = $query_string . "$table_single" . "ID int NOT NULL AUTO_INCREMENT, PRIMARY KEY(" . $table_single . "ID),";
    $query_string = $query_string . "createdAt date,";
    $query_string = $query_string . "updatedAt date,";
    foreach( $columns as $column => $datatype ) {
      $query_string = $query_string . $column . ' ' . $datatype . ',';
    }
    $query_string = rtrim( $query_string, ',' );
    $query_string = $query_string . ')';
    mysql_query( $query_string, $this->connection );
  }
  
  function create( $table_single, $columns_and_values ) {
    $table = $table_single . 's';
    $id_column = $table_single . "ID";
    $query_string = "INSERT INTO $table (";
    foreach( $columns_and_values as $column => $value ) {
      $query_string = $query_string . "$column,";
    }
    $query_string = $query_string . "createdAt";
    $query_string = $query_string . ") VALUES (";
    foreach( $columns_and_values as $column => $value ) {
      $query_string = $query_string . "'$value',";
    }
    $query_string = $query_string . "CURDATE()";
    $query_string = $query_string . ")";
    if( !mysql_query( $query_string, $this->connection ) ) {
      die( 'Fail: ' . mysql_error() );
    }
  }
  
  function select( $table_single, $id ) {
    $table = $table_single . 's';
    if( $id == -1 ){
      $qs = "SELECT * FROM $table";
    } else {
      $qs = "SELECT * FROM $table WHERE $table_single" . "ID=$id";
    }
    $query = mysql_query( $qs, $this->connection );
    if( $query ){
      $result = array();
      while( $row = mysql_fetch_array( $query ) ){
        array_push( $result, $row );
      }
      return $result;
    } else {
      die( 'Query FAIL: ' . mysql_error() );
    }
  }
  
  function select_newest( $table_single ) {
    $table = $table_single . 's';
    $qs = "SELECT * FROM $table ORDER BY $table_single" . "ID DESC LIMIT 0,1";
    $query = mysql_query( $qs, $this->connection );
    if( $query ){
      return mysql_fetch_array( $query );
    } else {
      die( 'Query FAIL: ' . mysql_error() );
    }
  }
  
  function select_by( $column, $table_single, $selector ) {
    $table = $table_single . 's';
    $qs = "SELECT * FROM $table WHERE $column=$selector";
    $query = mysql_query( $qs, $this->connection );
    if( $query ){
      $result = array();
      while( $row = mysql_fetch_array( $query ) ) {
        array_push( $result, $row );
      }
      return $result;
    } else {
      die( 'Query FAIL: ' . mysql_error() );
    }
    
  }
  
  function destroy( $table_single, $id ) {
    $table = $table_single . 's';
    $qs = "DELETE FROM $table WHERE $table_single" . "ID=$id";
    $query = mysql_query( $qs, $this->connection );
    if( !$query ) {
      die( 'Query FAIL: ' . mysql_error() );
    }
  }
  
  function get_column_information( $table ) {
    $qs = "SELECT * FROM $table";
    $query = mysql_query( $qs );
    if( !$query ) {
      die( 'Query FAIL: ' . mysql_error() );
    }
    $columns = array();
    while( $column = mysql_fetch_field( $query ) ) {
      array_push( $columns, $column );
    }
    return $columns;
  }
  
  function update( $table_single, $id, $columns_and_values ) {
    $table = $table_single . "s";
    $qs = "UPDATE $table SET ";
    foreach( $columns_and_values as $column => $value ) {
      $qs = $qs . "$column='$value',";
    }
    $qs = rtrim( $qs, ',' );
    $qs = $qs . "WHERE $table_single" . "ID=$id";
    $query = mysql_query( $qs, $this->connection );
    if( !$query ) {
      die( 'Query FAIL: ' . mysql_error() );
    }
    
    
  }
    
}