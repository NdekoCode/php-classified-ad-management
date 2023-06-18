<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\UsersModel;

class UsersController extends MainController
{
    public function __contruct()
    {
        $this->form = new Form();
    }
    public function login()
    {
        $form = new Form();
        if (!empty($_POST)) {
            $_POST = $this->form->validator->removeDirt($_POST);
            $form->validateFormLogin($_POST);
        }
        $form = $form->getLoginForm($_POST);
        $title = "Login";
        $this->render('users.auth', compact('form', 'title'));
    }
    public function register()
    {
        $form = new Form();
        if (!empty($_POST)) {
            $_POST = $form->validator->removeDirt($_POST);
            $isValid = $form->validateRegisterForm($_POST);
            if ($isValid) {
                $_POST['password'] =  password_hash($_POST['password'], PASSWORD_ARGON2I);
                $user = new UsersModel();
                $searchParam = $user->getVerifiedFieldData($_POST);
                $query = $user->findBy($searchParam, false, 'OR');
                if (is_bool($query)) {
                    $user->hydrateData($_POST)->create();
                    $_SESSION['alert']['success'] = "Your account was create successfully";
                    header('Location: /users/login');
                    exit();
                } else {
                    $_SESSION['alert']['danger'] =  "Email or Password is incorrect";
                }
            }
        }
        $form = $form->getRegisterForm($_POST);
        $title = "Register";
        $messages = $this->messages;
        $this->render('users.auth', compact('form', 'title', 'messages'));
    }
}
