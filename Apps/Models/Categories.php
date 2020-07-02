<?php

/**
 * Class Categories used to define table name
 * 
 * @author Min <Minhmyn97@gmail.com>
 */
class Apps_Models_Categories extends Apps_Libs_DbConnection
{   
    protected $tableName = "categories";

    /**
     * Function used to get all categories in table categories
     * be used in selection option html (add post) 
     *
     * @author Min <Minhmyn97@gmail.com>
     * @return array 
     */
    public function buildSelectBox() 
    {
        $query = $this->buildQueryParams([
            "select" => "id, name",
        ])->select();
        $result = ["" => "-- Select Category --"];

        foreach ($query as $row) {
            $result[$row["id"]] = $row["name"];
        }

        return $result;
    }
}
