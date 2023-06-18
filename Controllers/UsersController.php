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
        $form = $form->getLoginForm();
        $title = "Login";
        $this->render('users.auth', compact('form', 'title'));
    }
    public function register()
    {
        $form = new Form();
        $form = $form->getRegisterForm();
        $title = "Register";
        $this->render('users.auth', compact('form', 'title'));
    }
}
