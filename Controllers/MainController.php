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
        $title = "Home page";
        $this->render('main.index', compact('title'));
    }
    public function pageNotFound()
    {
        $this->setLayout('void');
        $title = "Page not found";
        $this->render('main.page-404', compact('title'));
    }
}
