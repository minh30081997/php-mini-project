<?php

/**
 * Class connection Databases
 * 
 * @author Min <Minhmyn97@gmail.com>
 * @date 2020-06-25 11:48
 */
class Apps_Libs_DbConnection
{
    protected $username = "root";
    protected $password = "Minh.30081997";
    protected $host = "localhost";
    protected $database = "news";
    protected $tableName;
    protected $queryParams = [];

    protected static $connectionInstance = null;


    public function __construct()
    {
        $this->connect();
    }

    /**
     * Function connection database with PDO object
     * 
     * @author Min <Minhmyn97@gmail.com>
     * @date 2020-06-25
     * @return new PDO
     */
    public function connect()
    {
        if (self::$connectionInstance === null) {
            try {
                self::$connectionInstance = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
                self::$connectionInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                echo $e->getMessage();
                die();
            }
        }
        return self::$connectionInstance;
    }

    /**
     * Function execute query
     *
     * @param [type] $sql
     * @param array $param
     * @return mixed: Result after execute()
     */
    public function query($sql, $param = [])
    {
        $query = self::$connectionInstance->prepare($sql);
        // $param as array including exception elements with condition Where
        // Ex: Select * where id = 'select *';
        // Make a error with execute 
        if (is_array($param) && $param) {
            $query->execute($param);
        } else {
            $query->execute();
        }

        return $query;
    }

    /**
     * Function test condition where resolve condition null value
     * @author Min <Minhmyn@gmail.com>
     * @param [type] $condition
     * @return string "Where $condition" or ""
     */
    public function buildCondition($condition)
    {
        if (trim($condition)) {
            return "where " . $condition;
        }
        return "";
    }

    /**
     * Function create full query
     *
     * @param [type] $params: $params as array
     * @return object of class Apps_Libs_DbConnection
     */
    public function buildQueryParams($params)
    {
        // General description of a query
        $default = [
            "select" => "",
            "where" => "",
            "other" => "",
            "param" => "",
            "field" => "",
            "value" => []
        ];

        $this->queryParams = array_merge($default, $params);

        // return object of Apps_Libs_DbConnection
        return $this;
    }

    /**
     * Function select all item
     *
     * @return result of query as array 
     */
    public function select()
    {
        $sql = 'Select' . " " . $this->queryParams["select"] . ' From ' . $this->tableName . " " . $this->buildCondition($this->queryParams["where"]) . " " . $this->queryParams["other"];
        $query = $this->query($sql, $this->queryParams["param"]);

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Function select one element in table
     *
     * @return void array[0]
     */
    public function selectOne()
    {
        $this->queryParams["other"] = "limit 1";
        // function select return an array $result
        // desire return one element 
        $data = $this->select();
        if ($data) {
            return $data[0];
        }
        return [];
    }

    /**
     * function insert() will add one or more element into table
     *
     * @return id of element
     */
    public function insert()
    {
        $sql = "Insert into" . " " . $this->tableName . " " .  $this->queryParams["field"];
        $query = $this->query($sql, $this->queryParams["value"]);
        if ($query) {
            // object PDO have method lastInsertId() return id insert element
            return self::$connectionInstance->lastInsertId();
        } else {
            return false;
        }
    }

    /**
     * Function update() 
     *
     * @return void
     */
    public function update()
    {
        $sql = "Update" . " " . $this->tableName . " " . "set" . " " . $this->queryParams["value"] . " " . $this->buildCondition($this->queryParams["where"]) . " " . $this->queryParams["other"];
        $query = $this->query($sql);
        return $query;
    }

    /**
     * Function delete()
     *
     * @return void
     */
    public function delete() 
    {
        $sql = "Delete From" . " " . $this->tableName . " " . $this->queryParams["value"] . " " . $this->buildCondition($this->queryParams["where"]) . " " . $this->queryParams["other"];
        $query = $this->query($sql);
        return $query;
    }
}
