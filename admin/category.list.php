<?php 
    require_once "./fn.php";

    $list = select_table( "SELECT * FROM categories" );

    header( "Content-Type: application/json" );
    // application

    echo json_encode( array(
        "scuess" => true,
        "result" => $list
    ) );