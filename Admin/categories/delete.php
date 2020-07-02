<?php

include "../../Apps/bootstrap.php";

$router = new Apps_Libs_Router();
$user = new Apps_Libs_UserIdentity();

$categories = new Apps_Models_Categories();

// Get id on path
$id = intval($router->getGet("id"));

$cateDetail = $categories->buildQueryParams([
    "where" => "id = :id",
    "param" => [":id" => $id],
])->selectOne();

if (!$cateDetail) {
    $router->pageNotFound();
}

$result = false;

if ($router->getPost("submit") && $id) {
    $result = $categories->buildQueryParams([
        "where" => "id = :id",
        "param" => [":id" => $id],
    ])->delete();
    if ($result) {
        $router->redirect("categories/index");
    } else {
        $router->pageError("Can not delete");
    }    
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Delete</title>
</head>

<body>
    <div>
        <p>Hi <?= $user->getName(); ?> <a href="<?= $router->createUrl("logout"); ?>">Logout</a></p>
        <h1>Do you want to Delete: <?= $cateDetail["name"]; ?></h1>
    </div>

    <div class="show-data">
        <form action="<?= $router->createUrl("categories/delete", ["id" => $cateDetail["id"]]) ?>" method="POST">
            <input type="submit" id="yes" name="submit" value="Yes">
            <input type="button" id="no" name="no" value="No">
        </form>
    </div>

    <script language="javascript">
        var noBtn = document.getElementById("no");
        noBtn.addEventListener("click", function() {
            window.location.href = "<?= $router->createUrl("categories/index") ?>";
        });
    </script>
</body>

</html>