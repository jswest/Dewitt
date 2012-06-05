<?php
include( "../scripts/access.php" );
//include( "../scripts/ci.php" );
include( "../scripts/utility.php");
include('_header.php');
$table = $_GET['table'];
$table_single = rtrim( $table, 's' );
$id = $_GET['id'];
$q->connect();
$q->select_database();
$columns = $q->get_column_information( $table );
$current = $q->select( $table_single, $id );
$current = $current[0];
?>
<a href="../admin"><nav id="back"></nav></a>
<div id="admin-create-content" class="out">
<h1>Edit <?php echo $table_single; ?></h1>
<form action="edit_action.php" method="post" enctype="multipart/form-data">
  <table>
    <?php
    $counter = 0;
    foreach( $columns as $column ) {
      if( $counter != 0 && check_to_include_in_action( $column->name ) ) {
        echo "<tr>";
          echo "<td>";
            echo "<label for='" . $column->name . "'>" . $column->name . "</label>";
          echo "</td>";
          echo "<td>";
            if( $column->type == 'blob') {
              echo "<textarea name='$column->name' id='$column->name' value=''>" . $current[$column->name] . "</textarea>";
            } elseif( $column->type != 'blob' && $column->name != 'bg' && $column->name != 'src' && $column->name != 'example' ) {
              echo "<input type='text' name='$column->name' id='$column->name' value='" . $current[$column->name] . "'>";
            } else {
              echo "<input type='file' name='$column->name' id='$column->name' value='" . $current[$column->name] . "'>";
            }
          echo "</td>";
        echo "</tr>";
      }
      $counter++;
    }
    ?>
    <tr>
      <td>
        <input type="text" class="hidden" id="table" name="table" value="<?php echo $table_single; ?>">
        <input type="text" class="hidden" id="id" name="id" value="<?php echo $id; ?>">
      </td>
      <td>
        <input type="submit" id="submit" value="save" >
      </td>
    </tr>
</div>