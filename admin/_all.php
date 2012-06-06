<?php
include( "../scripts/ci.php" );
include( "../scripts/utility.php");
$table = $_REQUEST['table'];
$table_single = rtrim( $table, 's' );
$q->connect();
$q->select_database();
$columns = $q->get_column_information( $table );
?>

<h1><?php echo $table ?></h1>
<h2 id="new">New <?php echo '<a href="create.php?table=' . $table . '">' . $table_single ?></a></h2>
<table>
<?php
echo "<tr>";
$counter = 0;
foreach( $columns as $column ){
  if( check_to_include_in_display( $column->name ) ){
    if( $counter == 0 ) {
      echo "<th>ID</th>";
    } else {
      echo "<th>" . $column->name . "</th>";      
    }
  }
  $counter++;
}
echo "<th>Edit</th>";
echo "<th>Destroy</th>";
echo "</tr>";

$things = $q->select( $table_single, -1 );
foreach( $things as $thing ) {
  echo "<tr>";
    foreach( $columns as $column ) {
      if( check_to_include_in_display( $column->name ) ) {  
        echo "<td>";
        echo $thing[$column->name];
        echo "</td>";
      }
    }
    $id = $thing[$columns[0]->name];
    echo "<td class='edit'><a href='edit.php?table=$table&id=$id'>Edit</a></td>";
    echo "<td class='destroy'><a href='destroy_action.php?table=$table&id=$id'>Destroy</a></td>";
  echo "</tr>";
}

$q->disconnect();
?>