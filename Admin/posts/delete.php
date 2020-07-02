<?php

include "../../Apps/bootstrap.php";

$router = new Apps_Libs_Router();
$user = new Apps_Libs_UserIdentity();

$posts = new Apps_Models_Posts();

$id = intval($router->getGet("id"));

var_dump($id);

?>