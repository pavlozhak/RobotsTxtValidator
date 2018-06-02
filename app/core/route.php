<?php
namespace Router;

class Router
{
    // Var contains instance of Router class
    private static $instance = null;
    // default controller and action
    private $defaultControllerName = 'MainController';
    private $defaultActionName = 'index';
    // controller and action from URI
    private $controllerName;
    private $actionName;
    // Model file names
    private $modelFileName;

    public function __construct() {}

    public static function getInstance()
    {
        if(self::$instance === null) {
            self::$instance = new Router();
        }
        return self::$instance;
    }

    public function start()
	{
		list(, $controllerNameFromURI, $actionNameFromURI) = explode('/', $_SERVER['REQUEST_URI']);

		// get controller name, make first letter uppercase and add suffix
        $this->controllerName = (empty($controllerNameFromURI)) ? $this->defaultControllerName : ucfirst($controllerNameFromURI).'Controller';
		
		// get action name
        $this->actionName = (empty($actionNameFromURI)) ? $this->defaultActionName : $actionNameFromURI;

		// create model file name from add suffix and extension to controller name
		$this->modelFileName = $this->controllerName."Model.php";

		// get model file
		if(file_exists("app/models/{$this->modelFileName}"))
		{
			include_once "app/models/{$this->modelFileName}";
		}

		// get controller file
		if(file_exists("app/controllers/{$this->controllerName}.php"))
		{
			include_once "app/controllers/{$this->controllerName}.php";
		}
		else
		{
			/*
			right here would be to throw an exception,
			but to simplify the right to make a redirect page 404
			*/
			Router::ErrorPage404();
		}
		
		// create controller
		$controller = new $this->controllerName;
		$action = $this->actionName;
		
		if(method_exists($controller, $action))
		{
			// get controller action
			$controller->$action();
		}
		else
		{
			// Here also it would be wiser to throw an exception
			Router::ErrorPage404();
		}
	
	}
	
	public static function ErrorPage404()
	{
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:'.$host.'Error/page_404');
    }
}