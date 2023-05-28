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
