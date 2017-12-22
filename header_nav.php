<?php
  require_once "./fn.php";

  $site_name = select_single( "SELECT `value` FROM options WHERE `key`='site_name'" );

  $site_logo = select_single( "SELECT `value` FROM options WHERE `key`='site_logo'" );

  $nav_menus = select_single( "SELECT `value` FROM options WHERE `key`='nav_menus'" );  

  $nav_menus_obj = json_decode( $nav_menus );
  // var_dump( $nav_menus_obj );
  // exit;
?>