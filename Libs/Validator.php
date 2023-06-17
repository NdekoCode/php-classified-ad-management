<?php

namespace App\Libs;

class Validator
{

    public function validFieldData(string $fieldValue): string
    {
        return trim(htmlspecialchars(strip_tags($fieldValue)));
    }

    public function hasValue($value): bool
    {
        return isset($value) || !empty($value);
    }
    public function notExist($value)
    {
        return !isset($value) || empty($value);
    }

    /**
     * Veriry if an value is not empty
     *
     * @param [type] $value
     * @return boolean
     */
    public function isNotEmpty($value): bool
    {
        return isset($value) && !empty($value);
    }

    /**
     * Valid an email address
     *
     * @param string $email
     * @return boolean
     */
    public function isValidEmail(string $email): bool
    {
        $regex = "/^[a-z]+\w*@[a-z]+\w*\.[a-z]{2,}$/i";
        return preg_match($regex, $email);
    }
}
