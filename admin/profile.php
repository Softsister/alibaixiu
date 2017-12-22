<?php
require_once "./fn.php";

$eamilAll = check_login();

if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {
  $upid = $_POST[ "id" ];
  $nickname = $_POST[ "nickname" ];
  $slug = $_POST[ "slug" ];
  $bio = $_POST[ "bio" ];
  run_non_select( "UPDATE users SET slug='$slug', nickname='$nickname', bio='$bio' WHERE id=$upid " );
   
  header( "Location: ./profile.php" );
  exit;
  
}
?>
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/assets/css/admin.css">
  <link rel="stylesheet" href="/assets/vendors/ckeditor/contents.css">
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
        <h1>我的个人资料</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="form-horizontal" method="POST">
        <?php if( isset( $eamilAll[ "id" ] ) ) { ?>
        <input type="hidden" name="id" value="<?php echo $eamilAll[ "id" ] ?>">
        <?php } ?>
        <div class="form-group">
          <label class="col-sm-3 control-label">头像</label>
          <div class="col-sm-6">
            <label class="form-image">
              <input id="avatar" type="file">

              <?php if ( empty( $eamilAll[ "avatar" ] ) ) { ?>
                <img src="/assets/img/default.png">
              <?php } else { ?>
                <img src="<?php echo $eamilAll[ "avatar" ]; ?>">
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
                    value="<?php echo $eamilAll[ "email" ]; ?>" 
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
                   value="<?php echo $eamilAll[ "slug" ]; ?>" 
                   placeholder="slug">
            <p class="help-block">https://zce.me/author/<strong>
              <?php echo $eamilAll[ "slug" ]; ?>    
            </strong></p>
          </div>
        </div>
        <div class="form-group">
          <label for="nickname" class="col-sm-3 control-label">昵称</label>
          <div class="col-sm-6">
            <input id="nickname" 
                   class="form-control" 
                   name="nickname" 
                   type="type" 
                   value="<?php echo $eamilAll[ "nickname" ]; ?>" 
                   placeholder="昵称">
            <p class="help-block">限制在 2-16 个字符</p>
          </div>
        </div>
        <div class="form-group">
          <label for="bio" class="col-sm-3 control-label">简介</label>
          <div class="col-sm-6">
            <textarea id="bio" name="bio" class="form-control" placeholder="Bio" cols="30" rows="6">
            <?php echo $eamilAll[ "bio" ]; ?>
          </textarea>
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

  <!-- 侧边栏 -->
  <?php $page_name = "profile" ?>
  
  <?php
    include_once "./inc/aside.php";
  ?>
  

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/ckeditor/ckeditor.js"></script>
  <script>NProgress.done()</script>

  <script>

    CKEDITOR.replace( $( "#bio" ).get( 0 ) );

    $( "#slug" ).on( "input", function () {
      $( this ) .next().find( "strong" ).text( this.value || 'slug' );
    } );

    $( "#avatar" ).on( "change", function () {
      var $that = $( this );
      var formData = new FormData();
      
      formData.append( "avatar", this.files[ 0 ] );
      
      formData.append( "id", $( 'form :hidden' ).val() );

      var xhr = new XMLHttpRequest();
      xhr.open( "POST", "./profile.avatar.php" );
      xhr.onreadystatechange = function () {
        if( xhr.readyState == 4 && xhr.status == 200 ){
          // console.log( xhr.responseText );
          var data = JSON.parse( xhr.responseText );
          $that.next().attr( "src", data.result );

        }
      };
      xhr.send( formData );
    } );
  </script>
</body>
</html>
