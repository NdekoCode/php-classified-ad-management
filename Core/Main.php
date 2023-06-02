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
    }
}
