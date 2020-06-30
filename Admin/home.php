<?php

$user = new Apps_Libs_UserIdentity();
$router = new Apps_Libs_Router();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>
    <div>
        <p>Hi <?php echo $user->getName(); ?> <a href="<?php echo $router->createUrl("logout"); ?>">Logout</a></p>
    </div>

    <div class="show-data">
        <ul>
            <li><a href="<?php echo $router->createUrl("post/posts") ?>">Manage Posts</a></li>
            <li><a href="<?php echo $router->createUrl("category/cate") ?>">Manage Category</a></li>
            <li><a href="<?php echo $router->createUrl("user/users") ?>">Manage Users</a></li>
        </ul>
    </div>
</body>
</html>




