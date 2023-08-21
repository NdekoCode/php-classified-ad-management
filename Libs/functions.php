<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "config.php";
/**
 * @SuppressWarnings(PHPMD)
 */

function debugPrint(mixed ...$data): void
{
    echo "<div><pre>";
    if (is_array($data)) {
        if (count($data) <= 1) {
            print_r($data[0]);
        } else {
            print_r($data);
        }
    } else {
        print_r($data);
    }
    echo "</pre></div>";
}
/**
 * @SuppressWarnings(PHPMD)
 */
function getControllerPath(string $controllerName): string
{
    return   "\App\Controllers\\" . ucfirst($controllerName) . "Controller";
}
/**
 * @SuppressWarnings(PHPMD)
 */
function varDumper(mixed ...$data): void
{
    echo "<div><pre>";

    if (count($data) <= 1) {
        var_dump($data[0]);
    } else {
        var_dump($data);
    }
    echo "</pre></div>";
}
function loadFile($dir = __DIR__, $file = __FILE__, $data = [])
{
    if ($data) {
        extract($data);
    }
    require_once ROOT_PATH . DS . $dir . DS . "$file.php";
}
function loadFileByPath($path, $file, $data = [])
{
    if ($data) {
        extract($data);
    }
    require_once $path . DS . "$file.php";
}
function addition(float $nb1, float $nb2): float
{
    return (float)($nb1 + $nb2);
}
function salutation($name, $salutation = "Salut")
{
    return "$salutation $name";
}
function validFieldData(string $fieldValue): string
{
    return trim(htmlentities(strip_tags($fieldValue)));
}
function clean(string|null $val = ""): string
{
    if (!empty($val)) {
        return  preg_replace('/[^a-zA-Z0-9\-\_]/', '', ($val));
    }
    return "";
}
function hasValue($value)
{
    return isset($value) || !empty($value);
}

function isNotEmpty($value)
{
    return isset($value) && !empty($value);
}
function validUploadFile(
    $file,
    $options = [
        "size" => 1_000_000,
        "extensions" => ["jpeg", "jpg", "gif", "svg", "png"]
    ]
): bool|array {
    if (isNotEmpty($file) && $file['error'] === 0) {
        if ($file['size'] <= $options['size']) {
            $fileInfos = pathinfo($file['name']);
            if (isNotEmpty($fileInfos) && isset($fileInfos['extension'])) {

                $extension_upload = $fileInfos['extension'];
                if (in_array($extension_upload, $options['extensions'])) {
                    return $fileInfos;
                }
            }
        }
    }
    return false;
}
function verifyAndUploadFile($file, $path = ROOT_PATH . "assets/files/")
{
    $fileInfos = validUploadFile($file);
    if (isNotEmpty($fileInfos)) {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $fileExtension = $fileInfos['extension'];
        $filePath = $path . trim($fileInfos['filename']) . uniqid() . ".$fileExtension";
        return  move_uploaded_file($file['tmp_name'], $filePath);
    }
    return false;
}
function isConnect(): bool
{
    return isset($_SESSION['user']);
}
function connectDb(): PDO
{
    $bdd = null;
    try {
        if (!$bdd) {

            $bdd = new PDO(
                "mysql:host=localhost;dbname=learn-php",
                "root",
                "7288Ndeko*",
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );
        }
        echo "DATABASE CONNECTION IS CORRECT";
        return $bdd;
    } catch (PDOException $e) {

        debugPrint("Erreur : " . $e->getMessage());
        die();
    }
}
function isValidStringField($value, $length = 1): bool
{
    return !empty($value) && strlen($value) >= $length;
}
function isValidEmail($value): bool
{
    return filter_var($value, FILTER_VALIDATE_EMAIL) && preg_match("#^[a-z]{2,}(\w|[\-\.])*@[a-z]{2,}(\w|[\-\.])*\.[a-z]{2,5}$#", $value);
}
function redirect(string $path, bool $last = true, int|null $httpCode = 0)
{
    if ($httpCode) {
        http_response_code($httpCode);
    }
    header("Location: $path", response_code: $httpCode);
    if ($last) {
        die();
    }
}
function dateHuman(string $date): string
{
    // convertir la date en objet DateTime si elle est sous forme de chaîne ou de timestamp
    if (is_string($date) || is_int($date)) {
        $date = new DateTime("$date");
    }
    // obtenir l'objet DateTime actuel
    $now = new DateTime();
    // calculer la différence sous forme d'un objet DateInterval
    $interval = $now->diff($date);
    // déterminer si la date est dans le futur ou dans le passé
    $future = $interval->invert ? "In " : "";
    $past = $interval->invert ? " ago" : "";
    // initialiser la variable pour stocker l'expression à retourner
    $expression = "";
    // choisir l'expression appropriée selon les propriétés de l'objet DateInterval
    if ($interval->y > 0) {
        // plus d'un an
        $expression = formatExpression($future, $interval->y, "year", $past);
    } elseif ($interval->m > 0) {
        // plus d'un mois
        $expression = formatExpression($future, $interval->m, "month", $past);
    } elseif ($interval->d > 0) {
        // plus d'un jour
        $expression = formatExpression($future, $interval->d, "day", $past);
    } elseif ($interval->h > 0) {
        // plus d'une heure
        $expression = formatExpression($future, $interval->h, "hour", $past);
    } elseif ($interval->i > 0) {
        // plus d'une minute
        $expression = formatExpression($future, $interval->i, "minute", $past);
    } else {
        // moins d'une minute
        $expression = "Just now";
    }
    // retourner l'expression finale
    return $expression;
}

// extraire une fonction pour formater l'expression selon le nombre et l'unité de temps
function formatExpression($prefix, $number, $unit, $suffix)
{
    return $prefix . $number . " " . $unit . ($number > 1 ? "s" : "") . $suffix;
}


function randomDate($start, $end): string
{
    $start = strtotime($start);
    $end = strtotime($end);
    $random = mt_rand($start, $end);
    return date('Y-m-d H:i:s', $random);
}
