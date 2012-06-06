<?php
include( 'ci.php' );
$q->connect();
$q->select_database();
$password = $q->select_newest( 'password' );

session_start();
if( !isset( $_SESSION['loggedIn'] ) ) {
  $_SESSION['loggedIn'] = false;
}

if( isset( $_POST['password'] ) ) {
  if( md5( $_POST['password'] ) == $password['password'] ) {
    $_SESSION['loggedIn'] = true;
  } else {
    die( 'WRONG PASSWORD' );
  }
}

if( !$_SESSION['loggedIn'] ) { ?>
  
  <html>
    <head>
      <title>LOGIN</title>
    </head>
    <body>
      <h1>LOGIN</h1>
      <form method="post">
        <table>
          <tr>
            <td>
              <label for="password">Password</label>
            </td>
            <td>
              <input type="password" name="password" id="password">
            </td>
          </tr>
          <tr>
            <td>
            </td>
            <td>
              <input type="submit" name="submit" value="Login">
            </td>
          </tr>
        </table>
      </form>
    </body>
  </html>
   
<?php
exit();  
}
?>