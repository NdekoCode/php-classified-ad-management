<?php

namespace App\Controllers;

class MainController extends Controller
{
    /**
     * Fournit la page principage de l'application
     *
     * @return void
     */
    public function index()
    {
        $this->render('main.index');
    }
    public function pageNotFound()
    {
        $this->render('main.page-404');
    }
}
