<?php
    require_once "./config.php";

    
    // 封装

    // 单个数据的函数
    function select_single( $sql ) {
        $conn = mysqli_connect( DB_IP, DB_USER, DB_PWD,DB_NAME );
        $reader = mysqli_query( $conn, $sql );
        // var_dump( $reader );
        $item = mysqli_fetch_row( $reader );
        mysqli_free_result( $reader );
        mysqli_close( $conn );
        return $item[ 0 ];
    }

    function select_table( $sql ) {
        $conn = mysqli_connect( DB_IP, DB_USER, DB_PWD,DB_NAME );
        $reader = mysqli_query( $conn, $sql );
        $list = array();
        while( $item = mysqli_fetch_assoc( $reader ) ){
            $list[] = $item;
        }
        mysqli_free_result( $reader );
        mysqli_close( $conn );
        return $list;
    }



