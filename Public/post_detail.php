<?php

$router = new Apps_Libs_Router();
$user = new Apps_Libs_UserIdentity();

$categories = new Apps_Models_Categories();
$posts = new Apps_Models_Posts();

$id = intval($router->getGet("id"));

$listCate = $categories->buildQueryParams()->select();
$listPost = $posts->buildQueryParams([
    "where" => $router->getGet("cate_id") ? "cate_id = " . intval($router->getGet("cate_id")) : "",
])->select();

if ($id) {
    $postDetail = $posts->buildQueryParams([
        "where" => "id = :id",
        "param" => [":id" => $id],
    ])->selectOne();

    if (!$postDetail) {
        $router->pageNotFound();
    }
} else {
    $router->pageNotFound();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Detail Page</title>
    <style>
        .menu {
            width: 100%;
            height: 8%;
            background: #DDD;
            text-align: center;
            padding: 17px;
        }

        .menu li {
            float: left;
            margin-left: 10px;
        }

        .list {
            width: 100%;
        }
    </style>
</head>

<body>
    <div>
        <h1>Web Tin</h1>
    </div>

    <div class="menu">
        <ul>
            <li><a href="<?= $router->createUrl("home") ?>">Home</a></li>
            <?php
            foreach ($listCate as $row) {
            ?>
                <li><a href="<?= $router->createUrl("home", ["cate_id" => $row["id"]]) ?>"><?= $row["name"] ?></a></li>
            <?php } ?>
        </ul>
    </div>

    <div class="list">
        <h3><?= $postDetail["name"] ?></h3>
        <h3><?= $postDetail["content"] ?></h3>
    </div>
</body>

</html>