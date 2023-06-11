<?php

namespace App\Controllers;

abstract class Controller
{
    public function render(string $pagePath, array $data)
    {
        extract($data);
        $pagePath = str_replace('.', DS, $pagePath);
        include_once ROOT_VIEWS . "$pagePath.php";
    }
}
