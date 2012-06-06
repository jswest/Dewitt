<?php
include('scripts/ci.php');
include('scripts/utility.php');
$q->connect();
$q->select_database();
$bg = $q->select_newest('background');
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $bg['title'];  ?></title>
    <link href='css/style.css' rel='stylesheet' style='text/css' />
    <link href='css/fonts.css' rel='stylesheet' style='text/css' />
    <script src='js/jquery.js' type='text/javascript'></script>
    <script src='js/coffeescript.js' type='text/javascript'></script>
    <script src="js/bg.js.coffee" type="text/coffeescript"></script>
    <script src="js/lightbox.js.coffee" type="text/coffeescript"></script>
    <script src="js/slider.js.coffee" type="text/coffeescript"></script>
    <script src="js/nav.js.coffee" type="text/coffeescript"></script>
  </head>
  
  <body>
    <div id='lightbox-gloss'></div>
    <div id='lightbox-image-wrapper'>
      <div id="lightbox-image-information">
        <h2 id="lightbox-title"></h2>
        <h2 id="lightbox-year"></h2>
        <div id="lightbox-materials"><p></p></div>
      </div>
    </div>
    
    <img id='bg' src="<?php echo $bg['bg'] ?>">
    
    <header id='primary-header'>
      <hgroup>
        <h1><?php echo $bg['title']; ?></h1>
      </hgroup>
    </header>
    
    <nav class='in' id='primary-nav'></nav>
    <ul id='primary-menu' class="in">
      <?php
        
        $pages = $q->select( 'page', -1 );
        if( $pages ){
          foreach( $pages as $page ) {
            echo "<li data-ajaxable='true' data-table='pages' data-id='" . $page['pageID'] . "'>" . $page['title'] . "</li>";
          }
        }
        
        echo "<li data-table='none'>Projects</li>";
        echo "<div id='secondary-menu-wrapper' class='in'>";
          echo "<ul id='secondary-menu' class='in'>";
            echo "<nav id='up-control' class='control'></nav>";
            echo "<nav id='down-control' class='control'></nav>";
            $projects = $q->select( 'project', -1 );
            foreach( $projects as $project ) {
              echo "<li data-table='projects' data-id='" . $project['projectID'] . "'>";
              echo "<h2>" . $project['title'] . "</h2>";
              echo "<img src='" . $project['example'] . "'>";
              echo "</li>";
            }
          echo "</ul>";
        echo "</div>";
        
        $years = $q->select( 'year', -1 );
        foreach( $years as $year ) {
          echo "<li data-ajaxable='true' data-table='years', data-id='" . $year['yearID'] . "'>" . $year['year'] . "</li>";
        }
        
      ?>
    </ul>
      
    <div id="line"></div>
    <div id="content-wrapper" class="in"></div>