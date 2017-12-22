<?php
    require_once "./fn.php";
    $id = $_REQUEST[ "id" ];
    $slug = $_REQUEST[ "slug" ];
    $name = $_REQUEST[ "name" ];

    $sql = "UPDATE categories SET slug='$slug',`name`='$name' WHERE id=$id";
    // $sql = "UPDATE categories SET slug='$slug' , `name`='$name' WHERE id=$id";

    run_non_select( $sql );

    header( "Content-Type: application/json" );

    echo json_encode(
            array(
                "success" => true
            )
        );