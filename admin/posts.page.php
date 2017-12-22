<?php

require_once "./fn.php";

$index = $_REQUEST[ "index" ];

// $sql = sprintf( "SELECT * FROM posts LIMIT %d, 10", ( $index - 1 ) * 10 );

$sql = "
SELECT 
    p.id  
  , p.title
  , u.nickname
  , c.name
  , p.created
  , p.status
FROM 
    posts AS p
    INNER JOIN
    users AS u
    ON p.user_id = u.id
    INNER JOIN
    categories AS c
    ON p.category_id = c.id
LIMIT 
    %d, 10
";

$sql = sprintf( $sql, ( $index - 1 ) * 10 );


$list = select_table( $sql );


// =====================================

$sql_count = "
SELECT 
   COUNT( * )
FROM 
    posts AS p
    INNER JOIN
    users AS u
    ON p.user_id = u.id
    INNER JOIN
    categories AS c
    ON p.category_id = c.id
";

$count = select_single( $sql_count ); 


header( "Content-Type: application/json" );

echo json_encode(array(
    "success"=>true,
    "result"=>array(
        "count"=> ceil ($count / 10),
        "list"=>$list
    )
));