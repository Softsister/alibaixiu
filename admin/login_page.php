<?php
    require_once "./fn.php";


    if( $_SERVER[ "REQUEST_METHOD" ] == "POST" ){
        if( empty( $_POST[ "email" ] ) || empty( $_POST[ "password" ] ) ){
            $message = "请完整填写表单";
        }else{
            $email = $_POST["email"];
            $password = $_POST["password"];
            // $emailpwd = select_table( "SELECT id,email,`password` FROM users WHERE email = '$email' AND `password`='$password'" );
            $id = select_single( "SELECT id FROM users WHERE email = '$email' AND `password`='$password'" );
            // var_dump( $emailpwd );
            if( empty( $id )) {
                // if( $password == $emailpwd[ 0 ][ "password" ]  ){
                    // setcookie( "email", $email );
                    // setcookie('is_logged_in', 'true');
                    
                $message = '邮箱与密码不匹配';
                
                // }else{
                    // $message = "邮箱与密码不匹配";
                // }
            }else{
                session_start();
                // 记住登录状态
                $_SESSION['current_user_login_id'] = $id;

                header('Location: /admin/index.php');
                exit;
            }
        }
    }

    // echo $message;