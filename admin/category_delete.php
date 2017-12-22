<?php
    require_once "./fn.php";

    $id = $_REQUEST[ "id" ];

    run_non_select( "DELETE FROM categories WHERE id in ( $id )" );

    header( "Content-Type: application/json" );

    echo json_encode( array( 
        "success" => true
     ) );