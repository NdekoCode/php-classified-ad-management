<?php

namespace App\Core;

use App\Libs\Validator;

class Form
{
    /**
     * Contient le code HTML du formulaire
     *
     * @var string
     */
    protected string $formCode = '';
    protected $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }
    /**
     * Genere le formulaire HTML
     *
     * @return string
     */
    public function create(): string
    {
        return $this->formCode;
    }

    /**
     * Valid if all fields is filled
     *
     * @param array $form formData Array ($_POST, $_GET)
     * @param array $fields Required fields Array ['email','firstName','lastName',...]
     * @return boolean
     */
    public function validate(array $form, array $fields): bool
    {
        // On parcours les champs
        foreach ($fields as $field) {
            // On verifie si le champs est absent ou vide dans le formulaire
            if ($this->validator->notExist($form[$field])) {
                // On sort en retournant false
                return false;
            } elseif ($field === 'email') {
                if (!$this->validator->isValidEmail($form[$field])) {
                    return false;
                }
            }
        }
        return true;
    }
}
