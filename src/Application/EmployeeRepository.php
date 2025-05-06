<?php
namespace Application\Employees;

use Model\EmployeeTransport;

interface EmployeeRepository
{
    public function search(string $name): ?EmployeeTransport;
}
