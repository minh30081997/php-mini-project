<?php

include "../../Apps/bootstrap.php";

$router = new Apps_Libs_Router();
$user = new Apps_Libs_UserIdentity();

$posts = new Apps_Models_Posts();

// Get id when redirect to page post delete
$id = intval($router->getGet("id"));

$postDetail = $posts->buildQueryParams([
    "where" => "id = :id",
    "param" => [":id" => $id],
])->selectOne();

if (!$postDetail) {
    $router->pageNotFound();
}

$result = false;

if ($router->getPost("submit") && $id) {
    $result = $posts->buildQueryParams([
        "select" => "",
        "where" => "id = :id",
        "param" => [":id" => $id],
    ])->delete();

    if ($result) {
        $router->redirect("posts/index");
    } else {
        $router->pageError("Can not delete database");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Delete</title>
</head>

<body>
    <div>
        <p>Hi <?= $user->getName() ?> <a href="<?= $router->createUrl("logout") ?>">Logout</a></p>
        <h1>Do you want to delete: <?= $postDetail["name"] ?></h1>
    </div>

    <div class="show-data">
        <form action="<?= $router->createUrl("posts/delete", ["id" => $postDetail["id"]]) ?>" method="POST">
            <input type="submit" name="submit" id="yesBtn" value="Yes">
            <input type="button" name="noBtn" id="noBtn" value="No">
        </form>
    </div>

    <script language="javascript">
        let noBtn = document.getElementById("noBtn");
        noBtn.addEventListener("click", function() {
            window.location.href = "<?= $router->createUrl("posts/index") ?>"
        });
    </script>
</body>

</html>