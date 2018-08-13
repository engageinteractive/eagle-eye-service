<?php

namespace App\EagleEye;

class Auth
{
    protected $username;
    protected $password;

    public function __construct($username, $password)
    {
        $this->setUsername($username);
        $this->setPassword($password);
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getAuth()
    {
        return [
            $this->username,
            $this->password,
        ];
    }
}
