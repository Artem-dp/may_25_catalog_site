<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Env;
use app\core\Language;
use app\models\admin\AboutModel;
use app\models\admin\CatalogModel;

class HomeController extends Controller
{
  public function index(){
      $lang = Language::getCurrentLanguage() ?? Env::config('DEFAULT_LANG');

      $model = new AboutModel();
      $data  = $model->getByLang($lang);

      $allowedLangs = Language::getLanguages();
      $currentLang = array_find($allowedLangs, function ($item) use ($lang) {
          return $item['code'] === $lang;
      });
      $catalogModel = new CatalogModel();
      $catalog = $catalogModel->getCategoriesWithProducts($currentLang['id']);
      $this->render('site/pages/home_template', [
          'catalog' => $catalog,
          ...$data
      ]);
  }
}