<?php

namespace app\controllers\admin;

use app\core\Auth;
use app\core\Controller;
use app\core\Router;

class LoginController extends Controller
{
    /**
     * displaying the admin login page
     * @return void
     */
    public function index(): void
    {
        $errors = $_SESSION['errors'] ?? [];
        $oldLoginInput = $_SESSION['oldLoginInput'] ?? '';
        unset($_SESSION['errors']);
        unset($_SESSION['oldLoginInput']);
        $this->render('admin/login_template', [
            'errors' => $errors,
            'oldLoginInput' => $oldLoginInput,
        ],
        'site/layouts/login_template');
    }

    /**
     * admin validation and login
     * @return void
     */
    public function login(): void
    {
        $errors = [];
        $login = $_POST['login'] ?? null;
        $password = $_POST['password'] ?? null;
        if (empty($login)) {
            $errors['login'] = 'Заполните логин';
        } elseif (strlen($login) < 3) {
            $errors['login'] = 'Не менее 3 символов';
        }
        if (empty($password)) {
            $errors['pass'] = 'Заполните пароль';
        }

        if (Auth::login($login, $password)) {
            Router::redirect('/admin/dashboard');
        } elseif(!isset($errors['login'])) {
            $errors['login'] = 'Неверный логин или пароль';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['oldLoginInput'] = $login;
            Router::redirect('/admin/login');
        }


    }

    /**
     * logout admin
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();
        Router::redirect('/admin/login');
    }

    public function redirectToDashboard()
    {
        if (Auth::check()) {
            Router::redirect('/admin/dashboard');
        } else {
            Router::redirect('/admin/login');
        }
    }
}