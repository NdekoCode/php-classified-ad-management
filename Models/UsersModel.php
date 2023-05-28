<?php

namespace App\Models;

class UsersModel extends Model
{
    protected  $id;
    protected string $pseudo;
    protected string $email;
    protected string $password;
    protected array $fillable = ['email', 'pseudo', 'password', 'active'];
    protected array $verifyFields = ['email', 'id'];
    public function __construct()
    {
        parent::__construct();
        $this->table = "users";
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of pseudo
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set the value of pseudo
     *
     * @return  self
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_ARGON2I);

        return $this;
    }

    /**
     * Get the value of verifyFields
     */
    public function getVerifyFields()
    {
        return $this->verifyFields;
    }

    /**
     * Set the value of verifyFields
     *
     * @return  self
     */
    public function setVerifyFields($verifyFields)
    {
        $this->verifyFields = $verifyFields;

        return $this;
    }
}
