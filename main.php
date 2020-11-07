<?php
    header('Content-type: application/json;charset=utf-8');
    require_once('config/db_config.php');
    require_once('function/CRUD.php');
    
    if($_SERVER['REQUEST_METHOD'] == "POST")        // create: 新增使用者資訊
    {
        
        $inputJson = json_decode(file_get_contents('php://input'));
         // 確認參數
        if(empty($inputJson) || !isset($inputJson->name) || !isset($inputJson->description))
        {
            echo json_encode(array(
                "status"    => 'error', 
                "message"   => 'Parameter is wrong'
            ),JSON_UNESCAPED_UNICODE);
        }
        else 
        {
            echo CRUD::create($inputJson);
        }
    }
    else if($_SERVER['REQUEST_METHOD'] == "GET")    // read: 取得使用者資訊
    {
         // 確認參數
        if(!isset($_GET['name']))
        {
            echo json_encode(array(
                "status"    => 'error', 
                "message"   => 'Parameter is wrong'
            ),JSON_UNESCAPED_UNICODE);
        }
        else
        {
            $input=array(
                "name"    => $_GET['name']
            );

            echo CRUD::read($input);
        }
    }
    else if($_SERVER['REQUEST_METHOD'] == "PUT")    // update: 更新使用者資訊
    {
        $inputJson = json_decode(file_get_contents('php://input'));
         // 確認參數
        if(empty($inputJson) || !isset($inputJson->name) || !isset($inputJson->description)) 
        {
            echo json_encode(array(
                "status"    => 'error', 
                "message"   => 'Parameter is wrong'
            ),JSON_UNESCAPED_UNICODE);
        }
        else 
        {
            echo CRUD::update($inputJson);
        }
    }
    else  if($_SERVER['REQUEST_METHOD'] == "DELETE") // delete: 刪除使用者資訊
    {
        // 確認參數
        if(!isset($_GET['name']))
        {
            echo json_encode(array(
                "status"    => 'error', 
                "message"   => 'Parameter is wrong'
            ),JSON_UNESCAPED_UNICODE);
        }
        else
        {
            $input=array(
                "name"    => $_GET['name']
            );

            echo CRUD::delete($input);
        }
    }
    else 
    {
        echo json_encode(array(
            "status"    => 'error', 
            "message"   => 'Request method not accepted'
        ),JSON_UNESCAPED_UNICODE);
    }
?>