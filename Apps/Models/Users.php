<?php

/**
 * Model Users used to define table name
 */
class Apps_Models_Users extends Apps_Libs_DbConnection
{   
    // Connect to users table
    protected $tableName = "users";
    
    /**
     * Function used to get all user in table users 
     * be used in select option html (add post)
     * 
     * @author Min <Minhmyn97@gmail.com>
     * @return array 
     */
    public function buildSelectBox()
    {
        $query = $this->buildQueryParams([
            "select" => "id, username",
        ])->select();
        $result = ["" => "-- Select User --"];
        foreach ($query as $row) {
            $result[$row["id"]] = $row["username"];
        }

        return $result;
    }
}
