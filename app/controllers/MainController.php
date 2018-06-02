<?php
use Controller\Controller as Controller;

class MainController extends Controller
{
	public function index()
	{	
		$this->view->render('main_view');
	}
}