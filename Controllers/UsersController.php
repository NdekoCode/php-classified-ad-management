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

                        $_SESSION['user'] = [
                            'firstName' => $user->getFirstName(),
                            'lastName' => $user->getLastName(),
                            'email' => $user->getEmail(),
                            'avatar' => $user->getAvatar(),
                            'active' => $user->getActive(),

                        ];
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
}
