<?php

/**
 * Le fichier centrale de notre projet
 * Ce fichier est là uniquement pour lancer le routeur
 * C'est ce fichier qui sera interroger à chaque fois que l'on va charger une page
 */

use App\Autoloader;
use App\Core\Main;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Libs' . DIRECTORY_SEPARATOR . 'functions.php';
require_once ROOT_PATH  . 'Autoloader.php';
Autoloader::register();

// On instancie Main, Main ça sera mon routeur
$app = new Main();
$app->start();
