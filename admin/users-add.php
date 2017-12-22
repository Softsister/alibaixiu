<?php
    require_once "./fn.php";

    $uaid = $_POST[ "id" ];
    // var_dump( $_POST );
    $slug = $_POST[ "slug" ];
    $nickname = $_POST[ "nickname" ];
    $password = $_POST[ "password" ];

    run_non_select( "UPDATE users SET slug='$slug', nickname='$nickname', password='$password' WHERE id=$uaid;" );
    header( "Location: ./users.php" );