<?php
require_once "./fn.php";

$eamilAll = check_login();

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
        <li><a href="profile.php"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="login.php"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form id="cat_info">

            <!-- 左侧数据 -->


          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action" style="height:30px">
            <!-- show when multiple checked -->
            <a id="delete_all" class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table id="cat_list" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              
              <!-- 数据 -->

              <!-- <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>未分类</td>
                <td>uncategorized</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>未分类</td>
                <td>uncategorized</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr> -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php $page_name = "categories" ?>
  <?php
    include_once "./inc/aside.php";
  ?>

  <script type="text/template" id="cat_list_tpl">
  {{ each list }}
  <tr data-id="{{ $value.id }}">
    <td class="text-center"><input class="tdck" type="checkbox"></td>
    <td>{{ $value.name }}</td>
    <td>{{ $value.slug }}</td>
    <td class="text-center">
      <a href="javascript:;" class="btn btn-info btn-xs catEdit">编辑</a>
      <a href="javascript:;" class="btn btn-danger btn-xs catDel">删除</a>
    </td>
  </tr>
  {{ /each }}
  </script>

<script type="text/template" id="cat_info_tpl">
  {{ if id }}
  <input type="hidden" name="id" value='{{ id }}' >
  {{ /if }}
  <h2>添加新分类目录</h2>
  <div class="form-group">
    <label for="name">名称</label>
    <input 
        id="name"
        class="form-control" 
        name="name" 
        type="text" 
        value="{{ name }}"
        placeholder="分类名称">
  </div>
  <div class="form-group">
    <label for="slug">别名</label>
    <input 
        id="slug" 
        class="form-control" 
        name="slug" 
        type="text" 
        value="{{ slug }}"
        placeholder="slug">
    <p class="help-block">https://zce.me/category/<strong>{{ slug || "slug" }}</strong></p>
  </div>
  <div class="form-group">
    <button class="btn btn-primary" type="submit">
    {{ id ? "修改" : "添加" }}
    </button>
    {{ if id }}
    <button id="Qx" class="btn btn-primary" >取消</button>
    {{ /if }}
  </div>
</script>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="/assets/vendors/template/template-web.js"></script>
  <script>NProgress.done()</script>

  <script>  
    // 发送 Ajax 请求数据 渲染到页面上
    function get_cat_list() {
      $.get( "./category.list.php", function ( json ) {
        $( "#cat_list tbody" ).html( template( "cat_list_tpl", { list: json.result } ) );
      } );
    }
    get_cat_list();

    // 删除
    $( "#cat_list" ).on( "click", ".catDel", function () {
      var delete_id = $( this ).parent().parent().attr( "data-id" );
        $.get( "./category_delete.php", { id: delete_id }, function ( info ) {
          if( info.success ) {
            get_cat_list();
          }
        } );
    } );

    // 批量删除
    $( '#cat_list thead :checkbox' ).on( 'change', function () {
        $( "#cat_list tbody .tdck" )
          .prop( "checked", this.checked )
          .trigger( "change" );
    });

    var ids = [];

    $( "#cat_list tbody" ).on( "change", ".tdck", function () {
      var id = $( this ).parent().parent().attr( "data-id" );
      var index = ids.indexOf( id );
      if( this.checked ){
        index == -1 && ids.push( id );
      }else {
        index > -1 && ids.splice( index, 1 );
      }

      $( '#cat_list thead :checkbox' )
        .prop( "checked", ids.length == $( "tbody .tdck" ).length );

      // if( ids.length > 0 ) {
      //   $( '#delete_all' ).show();
      // }else{
      //   $( '#delete_all' ).hide();
      // }
      
      $( '#delete_all' )[ ids.length > 0 ? "show" : "hide" ]();

    } );

    $( "#delete_all" ).click( function () {
      $.get( "./category_delete.php", { id : ids.join() }, function ( info ) {
        if( info.success ) {
          get_cat_list();
        }
      } );
    } );

     function cat_info() {
      $( '#cat_info' ).html( template( 'cat_info_tpl', {} ) );
     }
     cat_info();

    $( "#cat_info" ).on( "input", "#slug", function () {
      $( this ).next().find( "strong" ).text( this.value || "slug" );
    } );
    // 新增逻辑
    $( "#cat_info" ).on( "submit", function () {
      var data = $( this ).serialize();

      
      $.ajax( {
        url: data.indexOf( "id=" ) > -1 ?
                    './category_update.php'
                 : './category_insert.php',
        type: 'post',
        data: data,
        success: function ( info ) {
          // console.log( 1111 );
          console.log( info );
          info.success && get_cat_list();
          cat_info();
          }
      } );
      
      return false;
    } );


    //  修改
    $( "#cat_list" ).on( "click", ".catEdit", function () {

      var id = $( this ).parent().parent().attr( "data-id" );
      // console.log( id );
      var slug = $( this ).parent().prev().text();
      var name = $( this ).parent().prev().prev().text();
      // console.log( slug + ": " + name );
      $( '#cat_info' ).html( template( 'cat_info_tpl', {
        id : id,
        slug : slug,
        name : name
      } ) );

    } );
    $( "#Qx" ).click( function () {
      cat_info();
    } );
  </script>


</body>
</html>

