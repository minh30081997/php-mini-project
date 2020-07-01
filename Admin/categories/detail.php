<?php

include "../../Apps/bootstrap.php";

$router = new Apps_Libs_Router();
$user = new Apps_Libs_UserIdentity();

$categories = new Apps_Models_Categories();

// get $id when redirect page to category detail and convert to number
$id = intval($router->getGet("id"));

if ($id) {
    $cateDetail = $categories->buildQueryParams([
        "where" => "id =:id",
        "param" => [":id" => $id],
    ])->selectOne();

    if (!$cateDetail) {
        $router->pageNotFound();
    }
} else {
    $cateDetail = [
        "id" => "",
        "name" => ""
    ];
}

if ($router->getPost("submit") && $router->getPost("name")) {
    $param = [
        ":name" => $router->getPost("name"),
    ];

    $result = false;

    // case update 
    if ($id) {
        $param[":id"] = $id;
        $result = $categories->buildQueryParams([
            "select" => "",
            "value" => "name = :name",
            "where" => "id = :id",
            "param" => $param
        ])->update();
    }

    //case insert
    else {
        $result = $categories->buildQueryParams([
            "field" => "(name, created_by, created_time) values (?,?,now())",
            "value" => [$param[":name"], $user->getId()]
        ])->insert();
    }

    if ($result) {
        $router->redirect("categories/index");
    } else {
        $router->pageError("Can not update database!!!");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Detail</title>
</head>

<body>
    <div>
        <p>Hi <?= $user->getName(); ?> <a href="<?= $router->createUrl("logout"); ?>">Logout</a></p>
        <h1><?= !$id ? "Create new" : "Viewing "; ?>Category: <?= $cateDetail["name"]; ?></h1>
    </div>

    <div class="show-data">
        <form action="<?= $router->createUrl("categories/detail", ["id" => $cateDetail["id"]]) ?>" method="POST">
            Tittle:
            <br>
            Id: <input type="text" name="id" value="<?= $cateDetail["id"]; ?>">
            Name: <input type="text" name="name" value="<?= $cateDetail["name"]; ?>">
            <input type="submit" name="submit" value="Post">
            <input type="button" name="cancel" value="Cancel" id="cancel">
        </form>
    </div>

    <script language="javascript">
        var cancel = document.getElementById("cancel");
        cancel.addEventListener("click", function () {
            window.location.href = "<?= $router->createUrl("categories/index"); ?>";
        });
    </script>
</body>

</html>