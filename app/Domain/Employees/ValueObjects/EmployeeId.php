<?php

namespace App\Domain\Employees\ValueObjects;

final class EmployeeId
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
