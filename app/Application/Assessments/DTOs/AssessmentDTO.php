<?php

namespace App\Application\Assessments\DTOs;

class AssessmentDTO
{
    public string $id;
    public string $employeeId;

    public function __construct(string $id, string $employeeId)
    {
        $this->id = $id;
        $this->employeeId = $employeeId;
    }
}
