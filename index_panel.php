<?php
    require_once "./fn.php";

    header( "Content-Type: application/json" );
      // 最新发布文章

    $panel_new_data = select_table("SELECT 
    p.id
    , p.slug
    , p.title
    , p.feature
    , p.created
    , p.content
    , p.views
    , p.likes
    , p.`status`
    , u.nickname
    , c.`name`
    , m.count
    FROM
    posts AS p
    INNER JOIN
    users AS u
    ON p.user_id = u.id
    INNER JOIN
    categories as c
    ON p.category_id = c.id
    LEFT JOIN
    ( SELECT COUNT(*) AS count, post_id FROM comments GROUP BY post_id ) AS m
    ON p.id = m.post_id
    ORDER BY
		p.created DESC
	  LIMIT 10
    ");
    
    // var_dump( $panel_new_data );
    echo json_encode( array(
      "success" => true,
      "result" => $panel_new_data ) );
   // echo "111";