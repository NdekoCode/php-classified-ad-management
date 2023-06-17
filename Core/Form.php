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
    /**
     * Add attribute to the HTML field
     *
     * @param array $attributes Attributes to add in assiatives array ['class'=>"text-3xl",'required'=>true]
     * @return string The attributes
     */
    public function addAttributes(array $attributes): string
    {
        $str = "";
        if (!empty($attributes)) {

            // We list short attributes
            $short = ['checked', 'required', 'readonly', 'multiple', 'autofocus', 'novalidate', 'formnovalidate'];
            // We make a loop on the attributes array
            foreach ($attributes as $attribute => $value) {
                // if the attribute is in the shorts list array
                if (in_array($attribute, $short) && $value === true) {
                    $str .= "$attribute";
                } else {
                    $str .= "$attribute=\"$value\"";
                }
            }
        }
        return $str;
    }
    /**
     * Add the begin tag of HTML form <form>
     *
     * @param string $action the path to send form data
     * @param string $method form method (POST or GET)
     * @param array $attributes Attributes to add in the form tag
     * @return self
     */
    public function beginForm(string $action, $method = "POST", array $attributes = []): self
    {
        $this->formCode .= "<form action=\"$action\" method=\"$method\" {$this->addAttributes($attributes)}>";
        return $this;
    }
    /**
     * The end tag of html </form>
     *
     * @return self
     */
    public function endForm(): self
    {
        $this->formCode .= "</form>";
        return $this;
    }
    public function addLabelFor(string $text, $attributes = []): self
    {
        $this->formCode .= "<label {$this->addAttributes($attributes)}>$text</label>";
        return $this;
    }
    public function beginContainer($attributes = [], string $tagName = "div"): self
    {
        $this->formCode .= "<" . $tagName . " {$this->addAttributes($attributes)}>";
        return $this;
    }
    public function endContainer($tagName = "div"): self
    {
        $this->formCode .= "</" . $tagName . ">";
        return $this;
    }
    public function formTitle($title, $tagName = "h2"): self
    {

        $this->formCode .= "</" . $tagName . ">$title</$tagName>";
        return $this;
    }
}
