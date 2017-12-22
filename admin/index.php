<?php
  require_once "./fn.php";

  $eamilAll = check_login();


  // 2, 文章数据的查询
  $post_count = select_single( "SELECT COUNT(*) FROM posts" );
  $post_count_drafted = select_single( "SELECT COUNT(*) FROM posts WHERE `status`='drafted'" );

  $cate_count = select_single( "SELECT COUNT(*) FROM categories" );


  $comment_count = select_single( "SELECT COUNT(*) FROM comments" );

  $comment_count_held = select_single( "SELECT COUNT(*) FROM comments WHERE `status`='held'" );
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
        <li><a href="/admin/profile.php"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="/admin/login_out.php"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>One Belt, One Road</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.php" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong>
              <?php echo $post_count; ?>
              </strong>
              篇文章（<strong>
              <?php echo $post_count_drafted ?>
              </strong>篇草稿）</li>
              <li class="list-group-item"><strong>
              <?php echo  $cate_count; ?>
              </strong>个分类</li>
              <li class="list-group-item"><strong>
              <?php echo $comment_count; ?>
              </strong>条评论（<strong>
              <?php echo $comment_count_held; ?>
              </strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>

  <?php $page_name = "index" ?>
  <?php
    include_once "./inc/aside.php";
  ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
