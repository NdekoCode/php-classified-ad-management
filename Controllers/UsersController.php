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
        $form->beginForm("/user/login", "POST", ['class' => "p-10 border-[1px] -mt-10 border-slate-200 rounded-md flex flex-col items-center space-y-3"])
            ->beginContainer([
                'class' => "py-8"
            ])
            ->formTitle("Annonces Login", 'h2', ["class" => "font-medium my-3 text-3xl"])
            ->endContainer()
            ->beginContainer([
                'class' => "mb-3"
            ])
            // Input Email
            ->addInput([
                "placeholder" => "E-Mail or Phone number",
                'type' => 'email',
                'class' => "p-3 border-[1px] outline-none border-slate-500 rounded-sm w-80"
            ])
            ->endContainer()
            ->beginContainer([
                'class' => "flex flex-col space-y-1",
            ])->addInput([
                'type' => "password",
                'class' => "p-3 border-[1px]  outline-none border-slate-500 rounded-sm w-80",
                "placeholder" => "Password",
            ])
            ->addElement('Forgot password?', 'a', [
                'class' => "font-bold hover:underline text-[#0070ba] text-sm",
                "href" => "#"
            ])
            ->endContainer()
            ->beginContainer([
                'class' => "flex flex-col w-full space-y-5",
            ])
            // Button
            ->addButton('Login', [
                'class' => "w-full bg-[#0070ba] rounded-3xl p-3 text-white font-bold transition duration-200 hover:bg-[#003087]",
            ])
            ->beginContainer([
                'class' => "flex items-center justify-center border-t-[1px] border-t-slate-300 w-full relative"
            ])
            ->addElement("Or", 'div', ['class' => "absolute px-5 -mt-1 bg-white font-bod"])
            ->endContainer()
            ->addElement("Register", 'a', [
                'href' => "/users/register",
                "class" => "w-full border-blue-900 hover:border-[#003087] hover:border-[2px] border-[1px] rounded-3xl p-3 text-[#0070ba] font-bold transition duration-200 text-center"
            ])
            ->endContainer()
            ->endForm();
        $form = $form->create();
        $title = "Login";
        $this->render('users.auth', compact('form', 'title'));
    }
}
