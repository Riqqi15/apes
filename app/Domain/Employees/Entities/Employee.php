<?php

namespace App\Domain\Employees\Entities;

class Employee
{
    public string $id;
    public string $name;
    public string $department;

    public function __construct(string $id, string $name, string $department = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->department = $department;
    }
}
