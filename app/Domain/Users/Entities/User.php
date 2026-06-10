<?php

namespace App\Domain\Users\Entities;

/**
 * Domain entity representing a User.
 */
class User
{
    public string $id;
    public string $name;
    public string $email;

    public function __construct(string $id, string $name, string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }
}
