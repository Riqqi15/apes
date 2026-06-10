<?php

namespace App\Domain\Assessments\Entities;

class Assessment
{
    public string $id;
    public string $employeeId;
    public array $scores = [];

    public function __construct(string $id, string $employeeId, array $scores = [])
    {
        $this->id = $id;
        $this->employeeId = $employeeId;
        $this->scores = $scores;
    }
}
