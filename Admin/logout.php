<?php
include '../Apps/bootstrap.php';

$user = new Apps_Libs_UserIdentity();
$router = new Apps_Libs_Router();

$user->logout();
$router->loginPage();
?>