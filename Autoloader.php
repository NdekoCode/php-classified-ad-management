<?php

namespace App;

class Autoloader
{
    public static function register()
    {
        // spl_autoload_register: Permet de detecter les chargement des class, il detecte quand on fait un "new NomDeLaClasse" et lancer une fonction specifique
        // On va chercher la classe dans laquelle on se trouve et on va lacer une fonction appeler "autoload"
        spl_autoload_register([__CLASS__, 'autoload']);
    }
    /**
     * @SuppressWarnings(PHPMD)
     */

    private static function autoload($class)
    {
        // __NAMESPACE__ : le namespace dans lequel on se trouve donc "App"
        $class = str_replace(["\\", __NAMESPACE__], [DS], $class);
        $file = __DIR__ . DS . "$class.php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }

        echo "<br/><pre style=\"background-color='#FF5252'\">File $file not found</pre>";
        die();
    }
}
