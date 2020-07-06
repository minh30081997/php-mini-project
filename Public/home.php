<?php

$router = new Apps_Libs_Router();
$user = new Apps_Libs_UserIdentity();

$posts = new Apps_Models_Posts();
$categories = new Apps_Models_Categories();

// Get all category 
$listCate = $categories->buildQueryParams()->select();

// Get post follow cate_id
$listPost = $posts->buildQueryParams([
    "where" => $router->getGet("cate_id") ? "cate_id = " . intval($router->getGet("cate_id")) : "",
])->select();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

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
        <ul>
            <?php
            foreach ($listPost as $row) {
            ?>
                <li>
                    <a href="<?= $router->createUrl("post_detail", ["id" => $row["id"]]) ?>"><?= $row["name"] ?></a>
                    <p><?= $row["description"] ?></p>
                </li>
            <?php } ?>
        </ul>
    </div>
</body>

</html>