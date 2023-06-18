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
    protected $errors = [];
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
        $valid = true;
        // On parcours les champs
        foreach ($fields as $field) {
            // On verifie si le champs est absent ou vide dans le formulaire
            if ($this->validator->notExist($form[$field])) {
                $this->errors[$field] = ucfirst($field) . " is required";
                // On sort en retournant false
                $valid  = false;
            }
        }
        return $valid;
    }
    public function validateFormLogin(array $formData)
    {
        // Retourne true: si tous les champs on été remplis
        return $this->validate($formData, ["email", 'password']);;
    }
    /**
     * Valid register form Data when user want to register
     *
     * @param array $formData
     * @return boolean
     */
    public function validateRegisterForm(array $formData): bool
    {
        // Retourne true: si tous les de d'inscription sont correct
        $fieldValid =  $this->validate($formData, [
            'firstName', 'lastName', 'email', 'password', 'confpassword'
        ]);
        if (!$fieldValid) {
            return $fieldValid;
        }
        if (isset($formData['password'], $formData['email'], $formData['confpassword'])) {
            if (!$this->validator->isValidEmail($formData['email'])) {
                $fieldValid = false;
                $this->errors['email'] =  "Email is incorrect";
            }
            // Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character
            $regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
            if (!preg_match($regex, $formData['password'])) {
                $fieldValid = false;
                $this->errors['password'] = "Password must be minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character";
            }

            if ($formData['password'] !== $formData['confpassword']) {
                $this->errors['password'] = "The two password doesn't match";
                $fieldValid = false;
            }
        }

        return $fieldValid;
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
    public function formTitle($title, $tagName = "h2", array $attributes = []): self
    {

        $this->addElement($title, $tagName, $attributes);
        return $this;
    }
    public function addInput($attributes = []): self
    {
        $attributes = array_merge([
            'type' => 'text',
        ], $attributes);

        $this->formCode .= "<input {$this->addAttributes($attributes)} />";
        return $this;
    }

    public function addElement(string $text, string $tagName = "div", array $attributes = []): self
    {
        $this->formCode .= "<" . $tagName . " {$this->addAttributes($attributes)}>$text</$tagName>";
        return $this;
    }
    public function addTextarea(string $value = "", array $attributes = []): self
    {
        $attributes = array_merge(['cols' => '30', 'rows' => '5'], $attributes);
        $this->formCode .= "<textarea {$this->addAttributes($attributes)}>$value</textared>";
        return $this;
    }
    public function addSelect(array $options, array $attributes = [])
    {
        $this->formCode .= "<select {$this->addAttributes($attributes)}>";
        foreach ($options as $value => $text) {
            $this->formCode .= "<option value=\"$value\">$text</option>";
        }
        $this->formCode .= "</select>";
        return $this;
    }
    public function addButton(string $text, array $attributes = []): self
    {
        $this->addElement($text, 'button', $attributes);
        return $this;
    }
    /**
     * Add errors display
     *
     * @param string $errorText
     * @return self
     */
    public function errorsElement(string $errorText): self
    {
        if (!empty($errorText)) {

            $this->formCode .= <<<HTML
            <div class="text-error"><p><span class="font-medium">Oops! </span>$errorText</p></div>
HTML;
        }
        return $this;
    }
    public function getLoginForm(array $data = []): string
    {
        $this->beginForm("/users/login", "POST", ['class' => "form-shadow"])
            ->beginContainer([
                'class' => "py-8"
            ])
            ->formTitle("Annonces Login", 'h2', ["class" => "font-medium my-3 text-3xl"])
            ->endContainer()
            ->beginContainer([
                'class' => "field-container"
            ])
            // Input Email
            ->addInput([
                "placeholder" => "E-Mail or Phone number",
                'type' => 'email',
                'name' => 'email',
                'value' => $data['email'] ?? "",
                'class' => isset($this->errors['email']) ? "input-field invalid" : 'input-field',
            ])->errorsElement($this->errors['email'] ?? "")
            ->endContainer()
            ->beginContainer([
                'class' => "flex flex-col space-y-1",
            ])->addInput([
                'type' => "password",
                'class' => isset($this->errors['password']) ? 'input-field invalid' : 'input-field',
                "name" => 'password',
                "placeholder" => "Password",
            ])->errorsElement($this->errors['password'] ?? "")
            ->addElement('Forgot password?', 'a', [
                'class' => "bold-link",
                "href" => "#"
            ])
            ->endContainer()
            ->beginContainer([
                'class' => "flex flex-col w-full space-y-5",
            ])
            // Button
            ->addButton('Login', [
                'class' => "btn-form",
            ])
            ->beginContainer([
                'class' => "flex items-center justify-center border-t-[1px] border-t-slate-300 w-full relative"
            ])
            ->addElement("Or", 'div', ['class' => "absolute px-5 -mt-1 bg-white font-bod"])
            ->endContainer()
            ->addElement("Register", 'a', [
                'href' => "/users/register",
                "class" => "btn-form-outline"
            ])
            ->endContainer()
            ->endForm();
        return $this->create();
    }
    public function getRegisterForm(array $data = []): string
    {
        return $this->beginForm("/users/register", "POST", ['class' => "p-10 border-[1px] -mt-10 border-slate-200 rounded-md flex flex-col items-center "])
            ->beginContainer([
                'class' => "py-8"
            ])
            ->formTitle("Annonces Register", 'h2', ["class" => "font-medium my-3 text-3xl"])
            ->endContainer()
            // Input FistName
            ->beginContainer([
                'class' => "lg:flex lg:items-center lg:gap-x-3 w-full lg:max-w-[320px]",
            ])
            ->beginContainer([
                'class' => "mb-3 basis-1/2",
            ])->addInput([
                'class' => isset($this->errors['firstName']) ? 'input-field invalid' : 'input-field',
                "placeholder" => "Your firstName",
                "name" => "firstName",
                'value' => $data['firstName'] ?? ""
            ])->errorsElement($this->errors['firstName'] ?? "")
            ->endContainer()
            ->beginContainer([
                'class' => "mb-3  basis-1/2",
            ])->addInput([
                'class' => isset($this->errors['lastName']) ? 'input-field invalid' : 'input-field',
                "placeholder" => "Your lastName",
                "name" => "lastName",
                'value' => $data['lastName'] ?? ""
            ])->errorsElement($this->errors['lastName'] ?? "")
            ->endContainer()
            ->endContainer()

            ->beginContainer([
                'class' => "field-container"
            ])
            // Input Email
            ->addInput([
                "placeholder" => "E-Mail or Phone number",
                'type' => 'email',
                'name' => 'email',
                'value' => $data['email'] ?? "",
                'class' => isset($this->errors['email']) ? 'input-field invalid' : 'input-field',
            ])->errorsElement($this->errors['email'] ?? "")
            ->endContainer()
            ->beginContainer([
                'class' => "field-container"
            ])
            // Input Email
            ->addInput([
                "placeholder" => "Password",
                'type' => 'password',
                'name' => 'password',
                'class' =>  isset($this->errors['password']) ? 'input-field invalid' : 'input-field',
            ])->errorsElement($this->errors['password'] ?? "")
            ->endContainer()
            ->beginContainer([
                'class' => "field-container"
            ])
            // Input Email
            ->addInput([
                "placeholder" => "Confirm Password",
                'type' => 'password',
                'name' => "confpassword",
                'class' =>  isset($this->errors['confpassword']) ? 'input-field invalid' : 'input-field',
            ])->errorsElement($this->errors['confpassword'] ?? "")
            ->endContainer()
            ->beginContainer([
                'class' => "flex flex-col w-full space-y-5",
            ])
            // Button
            ->addButton('Register', [
                'class' => "btn-form ",
            ])
            ->beginContainer([
                'class' => "flex items-center justify-center border-t-[1px] border-t-slate-300 w-full relative"
            ])
            ->addElement("Or", 'div', ['class' => "absolute px-5 -mt-1 bg-white font-bod"])
            ->endContainer()
            ->addElement("Login", 'a', [
                'href' => "/users/login",
                "class" => "btn-form-outline"
            ])
            ->endContainer()
            ->endForm()->create();
    }
}
