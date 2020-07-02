<?php

include "../../Apps/bootstrap.php";

$router = new Apps_Libs_Router();
$user = new Apps_Libs_UserIdentity();
$posts = new Apps_Models_Posts();

// Select all post in table posts and order by id DESC
$query = $posts->buildQueryParams([
    "select" => "posts.id, posts.name, posts.description, posts.content, posts.created_time, posts.cate_id, categories.name as cateName, posts.created_by, users.username",
    "join" => "inner join categories on posts.cate_id = categories.id
               inner join users on posts.created_by = users.id",
    "other" => "order by posts.id DESC"
])->select();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts</title>
</head>

<body>
    <div>
        <p>Hi <?= $user->getName(); ?> <a href="<?= $router->createUrl("logout"); ?>">Logout</a></p>
        <h1>Manage Posts</h1>
    </div>

    <div class="show-data">
        <table style="width: 100%;" border="1">
            <thead>
                <th>Id</th>
                <th>Name</th>
                <th>Description</th>
                <th>Content</th>
                <th>Cate Id</th>
                <th>Category Name</th>
                <th>User By</th>
                <th>User Name</th>
                <th>Date</th>
                <th>Delete</th>
            </thead>
            <tbody>
                <?php foreach ($query as $post) { ?>
                    <tr>
                        <td><?= $post["id"] ?></td>
                        <td><a href="<?= $router->createUrl("posts/detail", ["id" => $post["id"]]) ?>"><?= $post["name"] ?> </a></td>
                        <td><?= $post["description"] ?></td>
                        <td><?= $post["content"] ?></td>
                        <td><?= $post["cate_id"] ?></td>
                        <td><a href="<?= $router->createUrl("categories/detail", ["id" => $post["cate_id"]]) ?>"><?= $post["cateName"] ?></a></td>
                        <td><?= $post["created_by"] ?></td>
                        <td><a href="<?= $router->createUrl("users/details", ["id" => $post["created_by"]]) ?>"><?= $post["username"] ?></a></td>
                        <td><?= $post["created_time"] ?></td>
                        <td><a href="<?= $router->createUrl("posts/delete", ["id" => $post["id"]]) ?>">Del</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>