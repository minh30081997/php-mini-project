<?php

/**
 * Class used to built router
 * 
 * @author Min <Minhmyn97@gmail.com>
 * @date 2020-06-29 15:50
 */
class Apps_Libs_Router
{
    const paramName = 'r';
    const homePage = 'home';
    const indexPage = 'index';

    // $sourcePath as path of directory current
    public static $sourcePath;

    /**
     * Function construct set value for $sourcePath
     *
     * @param string $sourcePath
     */
    public function __construct($sourcePath = "")
    {
        if ($sourcePath) {
            self::$sourcePath = $sourcePath;
        }
    }

    /**
     * Function used to get value $_GET
     *
     * @param [type] $name : as $_GET[self::paramName]
     * @return void
     */
    public function getGet($name = null)
    {
        if ($name !== null) {
            return isset($_GET[$name]) ? $_GET[$name] : null;
        }
        return $_GET;
    }

    /**
     * Function used to get value $_POST
     *
     * @param [type] $name
     * @return void
     */
    public function getPost($name = null)
    {
        if ($name !== null) {
            return isset($_POST[$name]) ? $_POST[$name] : null;
        }
        return $_POST;
    }

    /**
     * Function report page not found
     *
     * @return void
     */
    public function pageNotFound()
    {
        echo "404 Page Not Found";
        die();
    }

    /**
     * Function main Router
     *
     * @return void : include path file if exists else error
     */
    public function router()
    {
        // $url as value of function getGet (r=?)
        $url = $this->getGet(self::paramName);
        if (!$url || !is_string($url) || $url === self::indexPage) {
            $url = self::homePage;
        }
        // $path as full path to file 
        $path = self::$sourcePath . "/" . $url . ".php";
        if (file_exists($path)) {
            return include_once($path);
        } else {
            return $this->pageNotFound();
        }
    }

    /**
     * Function used to create a url
     *
     * @param [type] $url
     * @param array $params
     * @return url
     */
    public function createUrl($url, $params = [])
    {
        // $url as value of $paramName
        if ($url) {
            $params[self::paramName] = $url;
        }
        return $_SERVER["PHP_SELF"] . "?" . http_build_query($params);
    }

    /**
     * Function used to redirect web
     *
     * @param [type] $url
     * @return void
     */
    public function redirect($url)
    {
        $u = $this->createUrl($url);
        header("location:$u");
    }

    /**
     * Function redirect to home page
     *
     * @return void
     */
    public function homePage()
    {
        $this->redirect(self::homePage);
    }

    /**
     * Function redirect to login page
     *
     * @return void
     */
    public function loginPage()
    {
        $this->redirect("login");
    }

    public function logoutPage()
    {
        $this->redirect("logout");
    }

    public function pageError($err) 
    {
        echo $err;
    }

    public function redirectHome($url = "") 
    {   
        return str_replace("Admin", "Public", $this->createUrl($url));
    }
}
