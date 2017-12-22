<?php


// 思路:
// 接收用户上传的 图片 与 id
// 将图片放到指定的位置, 得到文件名
// 根据 id 更新数据库中的数据
// 返回 新路径( json )


var_dump( $_FILES );

var_dump( $_POST );