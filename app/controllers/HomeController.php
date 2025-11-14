<?php

namespace app\controllers;

use app\core\Controller;
use app\models\admin\AboutModel;

class HomeController extends Controller
{
  public function index(){
      $lang = $_GET['lang'] ?? 'ru';

      $model = new AboutModel();
      $data  = $model->getByLang($lang);
      $this->render('site/pages/home_template', $data);
  }
}