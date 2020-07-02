<?php
include "../../Apps/bootstrap.php";

$router = new Apps_Libs_Router();
$user = new Apps_Libs_UserIdentity();
$categories = new Apps_Models_Categories();
$users = new Apps_Models_Users();
$posts = new Apps_Models_Posts();

// Get id when redirect to posts detail and convert to number
$id = intval($router->getGet("id"));

// Select detail post in table posts with $id 
if ($id) {
    $postDetail = $posts->buildQueryParams([
        "where" => "id = :id",
        "param" => [":id" => $id],
    ])->selectOne();

    // If not found post return pageNotFound
    if (!$postDetail) {
        $router->pageNotFound();
    }
} else {
    $postDetail = [
        "id" => "",
        "name" => "",
        "description" => "",
        "content" => "",
        "cateName" => "",
        "username" => "",
        "cate_id" => "",
        "created_by" => "",
    ];
}

// Execute insert or update when click submit(post)
if (
    $router->getPost("post")
    && $router->getPost("name")
    && $router->getPost("category")
    && $router->getPost("user")
    && $router->getPost("description")
    && $router->getPost("content")
) {
    // Get value form
    $param = [
        ":name" => $router->getPost("name"),
        ":cate_id" => intval($router->getPost("category")),
        ":created_by" => intval($router->getPost("user")),
        ":description" => $router->getPost("description"),
        ":content" => $router->getPost("content"),
    ];

    $result = false;

    // update
    if ($id) {
        $param[":id"] = $id;
        $result = $posts->buildQueryParams([
            "select" => "",
            "value" => "name = :name, cate_id = :cate_id, created_by = :created_by, description = :description, content = :content",
            "where" => "id = :id",
            "param" => $param,
        ])->update();
    }

    // insert
    else {
        $result = $posts->buildQueryParams([
            "select" => "",
            "field" => "(id, name, cate_id, description, content, created_by, created_time) values (?, ?, ?, ?, ?, ?, now())",
            "value" => [$param[":id"], $param[":name"], $param[":cate_id"], $param[":description"], $param[":content"], $user->getId()],
        ])->insert();
    }

    if ($result) {
        $router->redirect("posts/index");
    } else {
        $router->pageError("Can not update database");
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Detail</title>
</head>

<body>
    <div>
        <p>Hi <?= $user->getName() ?> <a href="<?= $router->createUrl("logout") ?>">Logout</a></p>
        <h1><?= !$id ? "Create new" : "Viewing " ?>Posts: <?= $postDetail["name"] ?></h1>
    </div>
    <form action="<?= $router->createUrl("posts/detail", ["id" => $postDetail["id"]]) ?>" method="POST">
        Title:
        <input type="text" name="name" value="<?= $postDetail["name"] ?>">
        <br>
        Category:
        <select name="category" id="category">
            <?php
            $listCate = $categories->buildSelectBox();
            foreach ($listCate as $key => $value) {
            ?>
                <option <?= $key == $postDetail["cate_id"] ? "selected" : "" ?> value="<?= $key ?>"><?= $value ?></option>
            <?php } ?>
        </select>
        <br>
        User:
        <select name="user" id="user">
            <?php
            $listUser = $users->buildSelectBox();
            foreach ($listUser as $key => $value) {
            ?>
                <option <?= $key == $postDetail["created_by"] ? "selected" : "" ?> value="<?= $key ?>"><?= $value ?></option>
            <?php } ?>
        </select>
        <br>
        Description:
        <textarea name="description" id="des" cols="30" rows="10"><?= $postDetail["description"] ?></textarea>
        <br>
        Content:
        <textarea name="content" id="content" cols="30" rows="10"><?= $postDetail["content"] ?></textarea>
        <br>
        <input type="submit" name="post" value="Post" id="post">
        <input type="button" name="cancel" value="Cancel" id="cancel">
    </form>

    <script language="javascript">
        let cancelBtn = document.getElementById("cancel");
        cancelBtn.addEventListener("click", function() {
            window.location.href = "<?= $router->createUrl("posts/index") ?>"
        });
    </script>
</body>

</html>