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
            // Input Email
            ->addInput([
                "placeholder" => "E-Mail or Phone number",
                'type' => 'email',
                'class' => "p-3 border-[1px] border-slate-500 rounded-sm w-80"
            ])
            ->endContainer()
            ->beginContainer([
                'class' => "flex flex-col space-y-1",
            ])->addInput([
                'type' => "password",
                'class' => "p-3 border-[1px] border-slate-500 rounded-sm w-80",
                "placeholder" => "Password",
            ])
            ->addElement('Forgot password?', 'a', [
                'class' => "font-bold text-[#0070ba] text-sm",
                "href" => "#"
            ])
            ->endContainer()
            ->beginContainer([
                'class' => "flex flex-col w-full space-y-5",

            ])
            // Button
            ->endContainer()
            ->endForm();
        $loginForm = $form->create();
        varDumper($loginForm);
    }
}
