<?php

    // echo "退出";
    // 清除 session
    //  unset 删除
    //  销毁  
    session_start();

    unset( $_SESSION[ "current_user_login_id" ] );

    
    // session_destroy(  )

    header( "Location: /admin/login.php" );