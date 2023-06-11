<?php

namespace App\Controllers;

abstract class Controller
{
    public function render(string $pagePath = 'main.index', array $data = [])
    {
        // Par exemple : $data = ['a'=>'Valeur de a','b'=>'Valeur de B'], alors extract($data) donnera deux variables dont $a et $b et leurs contenus sont leurs valeurs dans le tableau $data
        extract($data); // Va extraire tous ce qui se trouve dans le tableau sous forme de variable dont le nom des variable sera la clé du tableau et la valeur sera la valeur correspondante de cette clé.
        ob_start();
        $pagePath = str_replace('.', DS, $pagePath);
        require_once ROOT_VIEWS . "$pagePath.php";
        $content = ob_get_clean();
        require_once ROOT_VIEWS . 'layout.php';
        exit();
    }
}
