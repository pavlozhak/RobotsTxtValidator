<?php
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/route.php';

use Model\model as Model;
use Router\router as Router;
use Controller\controller as Controller;
use View\view as view;

$router = Router::getInstance(); // get Router class instance
$router->start(); // start router