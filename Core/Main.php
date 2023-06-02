<?php

namespace App\Core;

class Main
{
    public function start()
    {
        echo "It works";
        // Routes: http://mon-domain.local/controller/method/parameter
        // TRUE URL: http://mon-domain.local/index.php?p=controller/method/parameter
        varDumper($_GET['p'] ?? "");
        // On recupère l'url après le nom de domaine donc le "/controller/method/parameter"
        $url = $_SERVER['REQUEST_URI'];
        // On verifie que l'URL n'est pas vide et qu'elle ne se termine pas par un "/"
        if (!empty($url) && $url[-1] === '/') {
            // On enleve le "/" à la fin
            $url = preg_replace("/\/+$/", "", $url);
            http_response_code(301);
            header("Location: $url");
        }
    }
}
