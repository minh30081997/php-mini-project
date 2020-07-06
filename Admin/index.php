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
// $test = new Apps_Models_Users();
// $param = [
//     // object PDO insert
//     "field" => "(username, password, created_time) values (?,?,now())",
//     "value" => ["ming", md5("ming")]
// ];

// $result = $test->buildQueryParams($param)->insert();
// var_dump($result); die();


// update 

// delete

// Router
$router = new Apps_Libs_Router(__DIR__);
$router->router();

// $test = new Apps_Models_Categories();

// $result = $test->buildQueryParams([
//     "select" => "",
//     "value" => "name = :name",
//     "where" => "id = :id",
//     "param" => [":id" => 1, ":name" => "min"],
// ])->update();

// var_dump($result);

// $test = new Apps_Models_Posts();

// $result = $test->buildQueryParams([
//     "select" => "",
//     "value" => "name = :name, cate_id = :cate_id, created_by = :created_by, description = :description, content = :content",
//     "where" => "id = :id",
//     "param" => [":id" => 1, ":name" => "Que", ":cate_id" => 1, ":created_by" => 1, ":description" => "que", ":content" => "que que"],
// ])->update();

// var_dump($result);