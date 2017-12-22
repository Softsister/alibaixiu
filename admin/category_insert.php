<?php
    require_once "./fn.php";

    $name = $_REQUEST[ "name" ];
    $slug = $_REQUEST[ "slug" ];

    // $sql = "INSERT INTO categories( slug, `name` ) VALUES ( '$slug', '$name' )";
    $sql = "INSERT INTO categories( slug, `name` ) VALUES( '$slug', '$name' )";    

    run_non_select( $sql );

    header( "Content-Type: application/json" );

    echo json_encode( array(
        "success" => true
    ) );