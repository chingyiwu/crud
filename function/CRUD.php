<?php
class CRUD
{
    public static function create($data)    // 創建使用者
    {
        global $_DB;
    
        $dbConn  = new mysqli($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
                    
        // 先檢查使用者是否存在
        $insert_db = 'SELECT `description` FROM `crud` WHERE `name`=\''.$data->name.'\'' ;
        $query   = $dbConn->query($insert_db);
        $row=$query->num_rows;

        if($row != 0) {     // 使用者已存在
            $result = json_encode(array(
                "status"    => 'error', 
                "message"   => 'user is exist'
            ),JSON_UNESCAPED_UNICODE);
        }
        else  {             // 創建新使用者
            $save_db = 'INSERT INTO `crud`(`name`,`description`) VALUES(\''.$data->name.'\', \''.$data->description.'\')' ;
            $query = $dbConn->query($save_db);
            $dbConn->close();
        
            $result = json_encode(array(
                "status"    => 'success', 
                "data"      => [ null ]
            ),JSON_UNESCAPED_UNICODE);
        }
        
        return $result;
    }
    
    public static function read($data)      // 取得使用者資料
    {
        global $_DB;
    
        $name = $data['name'];
        $description = [];
        
        $dbConn  = new mysqli($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
        $get_db = 'SELECT `description` FROM `crud` WHERE `name`=\''.$name.'\'' ;
        $query   = $dbConn->query($get_db);
        $row=$query->num_rows;

        if( $row==0 )   // 無使用者資料
        {
            $result = json_encode(array(
                "status" =>  'error',
                "message"=>  'no data'
            ),JSON_UNESCAPED_UNICODE);
        }
        else
        {
            for( $i=0 ; $i<$row ; ++$i )    // 取出資料存入陣列
            {
                $result  = $query->fetch_assoc()['description'];
                array_push($description, $result);
            }
            $dbConn->close();
        
            $result = json_encode(array(
                "status" =>  'success',
                "data"   =>  array(
                    'description'   => $description
                )
            ),JSON_UNESCAPED_UNICODE);
        }
        return $result;
    }

    public static function update($data)
    {
        global $_DB;
    
        $dbConn  = new mysqli($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
                    
        // 先檢查使用者是否存在
        $update_db = 'SELECT `description` FROM `crud` WHERE `name`=\''.$data->name.'\'' ;
        $query   = $dbConn->query($update_db);
        $row=$query->num_rows;

        if($row == 0)   // 使用者不存在
        {
            $result = json_encode(array(
                "status"    => 'error', 
                "message"   => 'user is not exist'
            ),JSON_UNESCAPED_UNICODE);
        }
        else            // 更新使用者資訊
        {
            $save_db = 'UPDATE `crud` SET `description` =  \''.$data->description.'\' WHERE `name`= \''.$data->name.'\'' ; 
            $query = $dbConn->query($save_db);
            $dbConn->close();

            $result = json_encode(array(
                "status"    => 'success', 
                "data"      => [ null ]
            ),JSON_UNESCAPED_UNICODE);
        }
        return $result;
    }

    public static function delete($data) 
    {
        global $_DB;
    
        $name = $data['name'];
                
        $dbConn  = new mysqli($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

        // 先檢先檢查使用者是否存在查
        $update_db = 'SELECT `description` FROM `crud` WHERE `name`=\''.$name.'\'' ;
        $query   = $dbConn->query($update_db);
        $row=$query->num_rows;

        if($row == 0)   // 使用者不存在
        {
            $result = json_encode(array(
                "status"    => 'error', 
                "message"   => 'no data'
            ),JSON_UNESCAPED_UNICODE);
        }
        else            // 刪除使用者資訊
        {
            $delete_db = 'DELETE FROM `crud` WHERE `name`=\''.$name.'\'' ;
            $query   = $dbConn->query($delete_db);
            $dbConn->close();

            $result = json_encode(array(
                "status"    => 'success', 
                "data"      => [ null ]
            ),JSON_UNESCAPED_UNICODE);
        }
        return $result; 
    }
}
?>