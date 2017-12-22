<?php

// 引入 库
require_once "./fn.php";


// 验证登录的状态
$user_info = check_login();


?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.html"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="login.html"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="page-title">
        <h1>我的个人资料</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="form-horizontal">
        <!-- 隐藏域: 与普通表单标签一样, 放在 form 标签中, 可以提供隐藏的提交数据 -->
        <?php if( isset( $user_info[ "id" ] ) ) { ?>
        <input type="hidden" name="id" value="<?php echo $user_info[ "id" ] ?>">
        <?php } ?>
        <div class="form-group">
          <label class="col-sm-3 control-label">头像</label>
          <div class="col-sm-6">
            <label class="form-image">
              <input id="avatar" type="file">
              <?php if ( empty( $user_info[ "avatar" ] ) ) { ?>
              <img src="../assets/img/default.png">
              <?php } else { ?>
              <img src="<?php echo $user_info[ "avatar" ] ?>">  
              <?php } ?>
              <i class="mask fa fa-upload"></i>
            </label>
          </div>
        </div>
        <div class="form-group">
          <label for="email" class="col-sm-3 control-label">邮箱</label>
          <div class="col-sm-6">
            <input id="email" 
                   class="form-control" 
                   name="email" 
                   type="type" 
                   value="<?php echo $user_info[ "email" ] ?>" 
                   placeholder="邮箱" 
                   readonly>
            <p class="help-block">登录邮箱不允许修改</p>
          </div>
        </div>
        <div class="form-group">
          <label for="slug" class="col-sm-3 control-label">别名</label>
          <div class="col-sm-6">
            <input id="slug" 
                   class="form-control" 
                   name="slug" 
                   type="type" 
                   value="<?php echo $user_info[ "slug" ] ?>" 
                   placeholder="slug">
            <p class="help-block">https://zce.me/author/
              <strong>
                <?php echo $user_info[ "slug" ] ?>
              </strong>
            </p>
          </div>
        </div>
        <div class="form-group">
          <label for="nickname" class="col-sm-3 control-label">昵称</label>
          <div class="col-sm-6">
            <input id="nickname" 
                   class="form-control" 
                   name="nickname" 
                   type="type" 
                   value="<?php echo $user_info[ "nickname" ] ?>" 
                   placeholder="昵称">
            <p class="help-block">限制在 2-16 个字符</p>
          </div>
        </div>
        <div class="form-group">
          <label for="bio" class="col-sm-3 control-label">简介</label>
          <div class="col-sm-6">
            <textarea id="bio" class="form-control" placeholder="Bio" cols="30" rows="6"><?php echo $user_info[ "bio" ] ?></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-6">
            <button type="submit" class="btn btn-primary">更新</button>
            <a class="btn btn-link" href="password-reset.php">修改密码</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php $page_name = "profile" ?>
  <?php include_once "./inc/aside.php" ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script>
    
    $( "#avatar" ).on( 'change' , function (){

      // this
      // console.log( this.files[ 0 ] );


      // 1, 准备数据容器
      var formData = new FormData();

      // 2, 将图片数据加入到容器中
      formData.append( "avatar", this.files[ 0 ] );

      // 3, 将用户 id 放到这里
      // 在表单中可以使用 :hidden 获得隐藏标签
      // 响应的表单过滤器还有 :checkbox   :button   :input  等
      formData.append( "id", $( 'form :hidden' ).val() );


      // 4, ajax
      var xhr = new XMLHttpRequest();
      xhr.open( "POST", "./profile.avatar.php" );
      xhr.onreadystatechange = function () {
        if ( xhr.readyState == 4 && xhr.status == 200 ) {
          // ...
          console.log( xhr.responseText );
        }

      };
      xhr.send( formData );

    });
  
  
  
  </script>
</body>
</html>
