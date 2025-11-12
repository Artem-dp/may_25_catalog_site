<?php

namespace app\controllers;

use app\core\Controller;

class HomeController extends Controller
{
  public function index(){
      $this->render('site/pages/home_template');
  }
}