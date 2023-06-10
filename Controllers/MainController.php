<?php

namespace App\Controllers;

use App\Controller\Controller;

class MainController extends Controller
{
    /**
     * Fournit la page principage de l'application
     *
     * @return void
     */
    public function index()
    {
        echo "Ceci est la page d'acceuil";
    }
}
