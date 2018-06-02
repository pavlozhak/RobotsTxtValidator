<?php
use Controller\Controller as Controller;

class ExportController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function export()
    {
        $model = new ExportControllerModel();
        $model->export2exel();
    }
}