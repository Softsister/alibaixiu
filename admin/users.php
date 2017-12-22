<?php
require_once "./fn.php";

$eamilAll = check_login();

// 删除操作

if( isset( $_GET[ "uid" ] ) ){
  $eid = $_GET[ 'uid' ];
  
  // 删除数据库中的数据
  
  run_non_select( "DELETE FROM users WHERE id in ( $eid )" );

  header( "Location: ./users.php" );
  exit;
  
}

if( isset( $_GET[ "uaid" ] ) ){
  $uaid = $_GET[ "uaid" ];

  $update_user_info = select_row( "SELECT * FROM users WHERE id = $uaid " );
  
}




// 显示所有的用户 排除自身

$users_info = select_table( "SELECT * FROM users WHERE id !=" . $eamilAll[ "id" ] );

$status_kv = array(
  "unactivated" => "未激活",
  "activated" => "激活",
  "forbidden" => "禁止",
  "trashed" => "回收站"
);



?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Users &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
      <li><a href="/admin/profile.php"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="/admin/login_out.php"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="page-title">
        <h1>用户</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">


          <form 
            action="<?php echo isset( $update_user_info ) ?
            './users-add.php' : './users-insert.php' ?>"
            
            method="post" >

            <?php if ( isset( $update_user_info ) ) { ?>
              <input type="hidden" name="id" value="<?php echo $update_user_info[ "id" ] ?>">
            <?php } ?>

            <h2>添加新用户</h2>
            <div class="form-group">
              <label for="email">邮箱</label>
              <input 
                  id="email"
                  class="form-control" 
                  name="email" 
                  type="email" 
                  value="<?php echo isset( $update_user_info ) ? $update_user_info[ "email" ] : '' ?>"
                  placeholder="邮箱">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input 
                    id="slug" 
                    class="form-control" 
                    name="slug" 
                    type="text" 
                    value="<?php echo isset( $update_user_info ) ? $update_user_info[ "slug" ] : '' ?>"
                    placeholder="slug">
              <p class="help-block">https://zce.me/author/<strong><?php echo isset( $update_user_info ) ? $update_user_info[ "slug" ] : 'slug' ?></strong></p>
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input 
                    id="nickname" 
                    class="form-control" 
                    name="nickname" 
                    type="text" 
                    value="<?php echo isset( $update_user_info ) ? $update_user_info[ "nickname" ] : '' ?>"
                    placeholder="昵称">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input 
                    id="password" 
                    class="form-control" 
                    name="password" 
                    type="text" 
                    value="<?php echo isset( $update_user_info ) ? $update_user_info[ "password" ] : '' ?>"
                    placeholder="密码">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">
              <?php echo isset( $update_user_info ) ? "修改" : '添加' ?>
              </button>
              <?php if( isset( $update_user_info ) ) { ?>
              <a href="./users.php" class="btn btn-warning">取消修改</a>
              <?php } ?>
            </div>
          </form>


        </div>





        <div class="col-md-8">
          <div class="page-action" style="height:30px;">
            <!-- show when multiple checked -->
            <a id="delect-all" class="btn btn-danger btn-sm" href="javascript:;" style="display: none;" >批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th class="text-center" width="80">头像</th>
                <th>邮箱</th>
                <th>别名</th>
                <th>昵称</th>
                <th>状态</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ( $users_info as $users ) { ?>
              <tr>
                <td class="text-center">
                  <input 
                    data-id="<?php echo $users[ "id" ]; ?>"
                    type="checkbox">
                  </td>
                <td class="text-center">
                <?php if( empty( $users[ "avatar" ] ) ) { ?>
                <img class="avatar" src="/assets/img/default.png">
                
                <?php } else { ?>
                  <img class="avatar" src="<?php echo $users[ "avatar" ] ?>">
                
                <?php } ?>
                </td>

                <td><?php echo $users[ "email" ] ?></td>
                <td><?php echo $users[ "slug" ] ?></td>
                <td><?php echo $users[ "nickname" ] ?></td>
                <td><?php echo $status_kv[ $users[ "status" ] ] ?></td>
                <td class="text-center">
                  <a href="?uaid=<?php echo $users[ "id" ]; ?>"  class="btn btn-default btn-xs">编辑</a>
                  <a href="?uid=<?php echo $users[ "id" ]; ?>" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <?php } ?>

              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


  <?php $page_name = "users" ?>
  <?php
    include_once "./inc/aside.php";
  ?>



  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>

  <script>
    $( '#slug' ).on( "input", function () {
      $( this ).next().find( "strong" ).text( this.value || 'slug' );
    });

    $( 'form' ).on( "submit", function () {
        console.log(  1213243 );
      // if ( 没有数据 ) {
      //   return false;
      // }

      // 思路: jq 的 serialize 方法得到的数据是一个字符串. 其格式为
      // k=v&kk=vv&kkk=vvv
      // 即判断 = 后面不允许是 字符串结尾 也不允许 = 后面是 & 
      // 使用 正则表达式   /=$|=&/
      var data = $( this ).serialize();

      if ( /=$|=&/.test( data ) ) {
        alert( '请填写完整信息' );

        return  false;
      }


    });


    var $thCk = $( "thead :checkbox" );
    var $tdCk = $( "tbody :checkbox" );
    var $del_all = $( "#delect-all" );
    // console.log( $thCk );
    // console.log( $tdCk );
    var ids = [];

    $tdCk.on( "change", function () {

      var curr_id = $( this ).attr( "data-id" );

      var index = ids.indexOf( curr_id );
      

      if( $( this ).prop( "checked" ) ){

        if( index == -1 ){
          ids.push( curr_id) ;
        }

      }else{
        
        if( index > -1 ){
          ids.splice( index, 1 );
        }

      }

     
      $thCk.prop( "checked", ids.length == $tdCk.length );

      if( ids.length > 0 ) {

        $del_all.stop().show().prop( "href", "./users.php?uid=" + ids.join() );
      }else {
        $del_all.stop().hide();
      }
    } );

    $thCk.on( "change", function () {
      $tdCk.prop( "checked", this.checked ).trigger( "change" );
    } );

  </script>
</body>
</html>
