<?php 
    
    require_once "./fn.php";
    // var_dump( $_FILES );

    $id = $_POST[ "id" ];
    date_default_timezone_set("Asia/Shanghai");

    $files_img = $_FILES[ "avatar" ];

    $info = $files_img[ "name" ];

    $files_index = strrpos( $info, "." );

    $ext_name = is_bool( $files_index ) ? '' : substr( $info, $files_index );

    $files_name = "/uploads/". time() . $ext_name;

    $sql = "UPDATE users SET avatar='$files_name' WHERE id=$id";

    run_non_select( $sql );
    

    move_uploaded_file( $files_img[ "tmp_name" ], ".." . $files_name );

    
    

    header( "Content-Type: application/json" );
    echo $id;

    echo json_encode(array(
        "success" => true,
        "result" => $files_name
    ));