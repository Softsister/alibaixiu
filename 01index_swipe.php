<?php
  require_once "./fn.php";
  
  header( "Content-Type: application/json" );

  echo select_single( "SELECT `value` FROM options WHERE `key`= 'home_slides'"  );


  