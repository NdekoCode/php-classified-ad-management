<?php

namespace App\Core;

use App\Controllers\MainController;
use App\Libs\Validator;

class Main
{
    public function start()
    {

        $validator = new Validator();
        // Routes: http://mon-domain.local/controller/method/parameter
        // TRUE URL: http://mon-domain.local/index.php?p=controller/method/parameter
        // On recupère l'url après le nom de domaine donc le "/controller/method/parameter"
        $uri = $_SERVER['REQUEST_URI']; // http://mon-domain.local/ON-VA-RECUPERER TOUS CE QUI SE TROUVE ICI
        // On verifie que l'URL n'est pas vide et qu'elle ne se termine pas par un "/"
        if (!empty($uri) && $uri[-1] === '/') {
            // On enleve le "/" à la fin
            $uri = preg_replace("/\/+$/", "", $uri);
            header("Location: $uri");
        }

        $urlOptions = explode("/", ($_GET['p'] ?? ""));

        $main = new MainController();
        if (!empty($urlOptions)) {
            // On a au moin un paramètre
            // On recupère le nom de l'instance à recuperer
            $controller = ($validator->isNotEmpty($urlOptions[0])) ? clean(array_shift($urlOptions)) : "main";
            $controller = getControllerPath($controller);

            $action = (isset($urlOptions[0]) && !empty($urlOptions[0]))  ? clean(array_shift($urlOptions)) : "index";

            if (class_exists($controller)) {
                $controller = new $controller();
                if (method_exists($controller, $action)) {
                    (isset($urlOptions[0]) && !empty($urlOptions)) ? call_user_func_array([$controller, $action], $urlOptions) : $controller->$action();
                    return;
                }

                $main->pageNotFound();
                return;
            }
            die("La classe n'existe pas");
        } else {
            $main->index();
        }
        // Pas de paramètre
        echo "Pas de paramètre";
    }
}
