<?php
/**
 * 
 */

include '../Apps/bootstrap.php';

// Create an instance object User
// $test = new Apps_Models_Users();

// select all, select one
// $param = [
//     "select" => "*",
//     "where" => ""
// ];
// $test->buildQueryParams($param);

// $result = $test->selectOne();
// var_dump($result);


// insert
// $param = [
//     // object PDO insert
//     "field" => "(username, password) values (?,?)",
//     "value" => ["ming", md5("ming")]
// ];

// $test->buildQueryParams($param);
// $result = $test->insert();
// var_dump($result);

// update 

// delete

// Router
$router = new Apps_Libs_Router(__DIR__);
$router->router();