<?php
    require_once "../config.php";

    
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
    function select_row( $sql ){
        return select_table( $sql )[ 0 ];
    }

    // 非查询语句
    function run_non_select( $sql ) {
        $conn = mysqli_connect( DB_IP, DB_USER, DB_PWD,DB_NAME );
        $reader = mysqli_query( $conn, $sql );
        mysqli_close( $conn );
    }


// 用户登录状态的函数
function check_login(){
    if( empty( $_COOKIE[ "PHPSESSID" ] ) ){
        header('Location: /admin/login.php');
        exit; // 结束代码继续执行
    }
    session_start();
    if (empty($_SESSION['current_user_login_id'])) {
        // 没有登录标识就代表没有登录
        // 跳转到登录页
        header('Location: /admin/login.php');
        exit; // 结束代码继续执行
    }
    $id = $_SESSION[ "current_user_login_id" ];
    return select_row( "SELECT * FROM users WHERE id=$id" );
}