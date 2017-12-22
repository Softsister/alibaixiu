<?php
    require_once "./fn.php";
    $email = $_POST[ "email" ];
    $slug = $_POST[ "slug" ];
    $nickname = $_POST[ "nickname" ];
    $password = $_POST[ "password" ];
    $status = "activated";
    $sql = "INSERT INTO users( `email`, `password`, `slug`, `status`, `nickname` ) VALUES
    ( '$email', '$password', '$slug', '$status', '$nickname' )";
    // sql命令
    run_non_select( $sql );
    
    header( "Location: ./users.php" );