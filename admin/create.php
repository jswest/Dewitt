<?php
include( "../scripts/access.php" );
include( "../scripts/utility.php");
include('_header.php');
$table = $_GET['table'];
$table_single = rtrim( $table, 's' );
$q->connect();
$q->select_database();
$columns = $q->get_column_information( $table );
?>
<a href="../admin"><nav id="back"></nav></a>
<div id="admin-create-content" class="out">
<h1>New <?php echo $table_single; ?></h1>
<form action="create_action.php" method="post" enctype="multipart/form-data">
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
              echo "<textarea name='$column->name' id='$column->name' ></textarea>";
            } elseif( $column->type != 'blob' && $column->name != 'bg' && $column->name != 'src' && $column->name != 'example' ) {
              echo "<input type='text' name='$column->name' id='$column->name'>";
            } else {
              echo "<input type='file' name='$column->name' id='$column->name'>";
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
      </td>
      <td>
        <input type="submit" id="submit" value="save" >
      </td>
    </tr>
</div>