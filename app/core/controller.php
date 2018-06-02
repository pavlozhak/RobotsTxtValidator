<?php
namespace Controller;

use View\View as view;

class Controller {
	
	public $model;
	public $view;
	
	public function __construct()
	{
		$this->view = new View();
	}
	
	public function setContentType($contentType)
    {
        header("Content-Type: {$contentType};charset=utf-8");
        return $this;
    }

    public function jsonEncode($array2json = array())
    {
        echo json_encode($array2json);
    }
}