<?php

include '../Apps/bootstrap.php';

$router = new Apps_Libs_Router();

$account = trim($router->getPost("account"));
$password = trim($router->getPost("password"));

$identity = new Apps_Libs_UserIdentity();

if ($identity->isLogin()) {
    $router->homePage();
}

if ($router->getPost("submit") && $account && $password) {
    $identity->username = $account;
    $identity->password = $password;

    if ($identity->login()) {
        $router->homePage();
    } else {
        echo "Username or password is incorrect!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form action="<?php echo $router->createUrl('login') ?>" method="POST">
        Account: <input type="text" name="account">
        <br>
        Password: <input type="password" name="password">
        <br>
        <input type="submit" name="submit" value="Login">
    </form>
</body>

</html>