<?php
session_start();

/**
 * Class used to manager login, logout of user
 * 
 * @author Min <Minhmyn97@gmail.com>
 * @date 2020-06-29 17:22
 */
class Apps_Libs_UserIdentity 
{
    public $username;
    public $password;

    protected $id;

    /**
     * Function construct
     *
     * @param [type] $username
     * @param [type] $password
     */
    public function __construct($username = "", $password = "")
    {   
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Function used to encoding password with method md5() 
     *
     * @return void
     */
    public function encryptPassword() 
    {
        return md5($this->password);
    }

    /**
     * Function used to check login of user
     *
     * @return true or false
     */
    public function login()
    {
        $db = new Apps_Models_Users();
        $query = $db->buildQueryParams([
            "where" => "username = :username AND password = :password",
            "param" => [
                ":username" => trim($this->username),
                ":password" => $this->encryptPassword()
            ]
        ])->selectOne();

        if($query) {
            $_SESSION["userId"] = $query["id"];
            $_SESSION["username"] = $query["username"];
            return true; 
        }
        return false;
    }

    /**
     * Function used to logout user with method unset()
     *
     * @return void
     */
    public function logout()
    {
        unset($_SESSION["userId"]);
        unset($_SESSION["username"]);
    }

    /**
     * Function used to get session 
     *
     * @param [type] $name
     * @return $_SESSION[$name]
     */
    public function getSession($name = null) 
    {
        if($name !== null) {
            return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
        }
        return $_SESSION;
    }

    /**
     * Function used to check login ? 
     *
     * @return boolean
     */
    public function isLogin() 
    {
        if($this->getSession("userId")) {
            return true;
        }
        return false;
    }

    /**
     * Function used to get id of user login
     *
     * @return number
     */
    public function getId()
    {
        return $this->getSession("userId");
    }

    /**
     * Function used to get username of user login
     *
     * @return void
     */
    public function getName() 
    {
        return $this->getSession("username");
    }
}