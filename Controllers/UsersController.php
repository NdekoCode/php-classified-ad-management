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
    public function register()
    {
        $this->redirectConnectedUser();
        $data = $_SESSION['formData'] ?? [];
        $form = new Form();
        // 7288*#Arick
        if (!empty($_POST)) {
            $data = $form->validator->removeDirt($_POST);
            $isValid = $form->validateRegisterForm($data);
            if ($isValid) {
                $user = new UsersModel();
                $searchParam = $user->getVerifiedFieldData($data);
                $query = $user->findBy($searchParam, false, 'OR');
                if (is_bool($query)) {
                    $user->hydrateData($data)->create();
                    $_SESSION['alert']['success'] = "Your account was create successfully";
                    $this->redirect('/users/login');
                } else {
                    $_SESSION['alert']['danger'] =  "Email or Password is incorrect";
                    $this->redirect('/users/register');
                }
            }
        }

        $form = $form->getRegisterForm($data);
        $title = "Register";
        $this->render('users.auth', compact('form', 'title'));
    }
    public function login()
    {
        $this->redirectConnectedUser();
        $data = $_SESSION['formData'] ?? [];
        $form = new Form();
        if (!empty($_POST)) {
            $data =  $form->validator->removeDirt($_POST);
            $isValid = $form->validateFormLogin($data);
            if ($isValid) {
                $userModel = new UsersModel();
                $searchParam = $userModel->getVerifiedFieldData($data);
                /**
                 * @var \App\Models\UsersModel $user
                 */
                $user = $userModel->findBy($searchParam, false, 'OR');
                if (!is_bool($user)) {
                    $verify = password_verify($data['password'], $user->getPassword());

                    if ($verify) {
                        $user->setSession();
                        $_SESSION['alert']['success'] = "Your are connected successfully";
                        $this->redirect('/users/profile');
                    } else {
                        $_SESSION['alert']['danger'] =  "Email or Password is incorrect";
                        $_SESSION['formData'] = $data;
                        $this->redirect('/users/login');
                    }
                } else {
                    $_SESSION['alert']['danger'] =  "Email or Password is incorrect";
                    $this->redirect('/users/login');
                }
            }
        }
        $form = $form->getLoginForm($data);
        $title = "Login";
        $this->render('users.auth', compact('form', 'title'));
    }
    public function  profile()
    {
        $this->forceConnexion();

        $title = "Profile {$_SESSION['user']['firstName']} {$_SESSION['user']['lastName']}";
        $userModel = new UsersModel();
        $user = $userModel->find($_SESSION['user']['id']);
        if ($this->isValidUser($user)) {
            $this->render('users.profile', compact('title', 'user'));
        } else {
            $this->redirect('/users/login');
        }
    }
    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        $this->redirect('/users/login');
    }
}
