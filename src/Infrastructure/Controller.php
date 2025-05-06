<?php
namespace Infrastructure;

use Application\Employees\EmployeeRepository;
use Application\TransportCompensationCalculator;
use JetBrains\PhpStorm\NoReturn;

readonly class Controller
{
    public function __construct(
        private CsvBuilder                      $builder,
        private EmployeeRepository              $employeeRepository,
        private TransportCompensationCalculator $calculator,
    ) {}

    #[NoReturn]
    public function getYearOverview(string $employee) {
        $employeeTransport = $this->employeeRepository->search($employee);
        if (empty($employeeTransport)) {
            throw new \Exception("The employee is not known in the system");
        }

        $this->builder->build(
            $employeeTransport,
            $this->calculator->calculate($employeeTransport)
        );
    }
}
