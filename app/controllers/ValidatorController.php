<?php
use Controller\Controller as Controller;

class ValidatorController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->render('validator/validator_view');
    }

    public function run()
    {
        $model = new ValidatorControllerModel();
        $this->setContentType('application/json')->jsonEncode($model->runValidate('siteUrl'));
    }
}