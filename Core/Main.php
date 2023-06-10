<?php

namespace App\Core;

use App\Controllers\MainController;

class Main
{
    public function start()
    {
        echo "It works";
        // Routes: http://mon-domain.local/controller/method/parameter
        // TRUE URL: http://mon-domain.local/index.php?p=controller/method/parameter
        varDumper($_GET['p'] ?? "");
        // On recupère l'url après le nom de domaine donc le "/controller/method/parameter"
        $uri = $_SERVER['REQUEST_URI']; // http://mon-domain.local/ON-VA-RECUPERER TOUS CE QUI SE TROUVE ICI
        // On verifie que l'URL n'est pas vide et qu'elle ne se termine pas par un "/"
        if (!empty($uri) && $uri[-1] === '/') {
            // On enleve le "/" à la fin
            $uri = preg_replace("/\/+$/", "", $uri);
            http_response_code(301);
            header("Location: $uri");
        }
        $urlOptions = explode("/", validFieldData($_GET['p'] ?? ""));
        if ($urlOptions[0] !== '') {
            // On a au moin un paramètre
            return;
        } else {
            $main = new MainController();
            $main->index();
        }
        // Pas de paramètre
        echo "Pas de paramètre";
    }
}
