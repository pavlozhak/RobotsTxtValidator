<?php
use Controller\Controller as Controller;

class ErrorController extends Controller
{
    public function page_404()
    {
        $this->view->render('errors/404_page');
    }
}