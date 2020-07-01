<?php

$router = new Apps_Libs_Router();
$user = new Apps_Libs_UserIdentity();
$categories = new Apps_Models_Categories();

// select all category in table categories
$query = $categories->buildQueryParams(["other" => "order by id DESC"])->select();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
</head>
<body>
    <div>
        <!-- can write <= $user->getName > -->
        <p>Hi <?php echo $user->getName() ?> <a href="<?php echo $router->createUrl("logout") ?>">Logout</a></p>
        <h1>Manage Categories</h1>
    </div>

    <div class="show-data">
        <table style="width: 100%;" border="1">
            <thead>
                <th>Id</th>
                <th>Name</th>
                <th>Date</th>
                <th>Delete</th>
            </thead>
            <tbody>
                <?php foreach($query as $row) { ?>
                    <tr>
                        <td><?= $row["id"]; ?></td>
                        <td><a href="<?= $router->createUrl("categories/detail", ["id" => $row["id"]]) ?>"><?= $row["name"]; ?></a></td>
                        <td><?= $row["created_time"]; ?></td>
                        <td><a href="<?= $router->createUrl("categories/delete", ["id" => $row["id"]])?>">Del</a></td>
                    </tr>
                <?php } ?> 
            </tbody>
        </table>
    </div>
</body>
</html>