<?php

namespace App\Controllers;

use App\Core\Form;

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
            $_POST = $this->form->validator->removeDirt($_POST);
            $isValid = $form->validateRegisterForm($_POST);
            if ($isValid) {
                extract($_POST);
            }
        }
        $form = $form->getRegisterForm($_POST);
        $title = "Register";
        $this->render('users.auth', compact('form', 'title'));
    }
}
