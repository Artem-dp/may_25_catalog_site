<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Env;
use app\core\Language;
use app\models\admin\AboutModel;

class HomeController extends Controller
{
  public function index(){
      $lang = Language::getCurrentLanguage() ?? Env::config('DEFAULT_LANG');

      $model = new AboutModel();
      $data  = $model->getByLang($lang);
      $this->render('site/pages/home_template', $data);
  }
}