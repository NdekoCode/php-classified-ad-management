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
        $form->beginForm("/user/login", "POST")
            ->beginContainer([
                'class' => "py-8"
            ])
            ->formTitle("Annonces Login")
            ->endContainer()
            ->beginContainer([
                'class' => "mb-3"
            ])
            // Input
            ->endContainer()
            ->endForm();
        $loginForm = $form->create();
        varDumper($loginForm);
    }
}
