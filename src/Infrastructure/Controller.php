<?php
namespace Infrastructure;

use Application\Employees\EmployeeRepository;
use Application\TransportCompensationCalculator;
use JetBrains\PhpStorm\NoReturn;

readonly class Controller
{
    public function __construct(
        private CsvBuilder                      $csvBuilder,
        private EmployeeRepository              $employeeRepository,
        private TransportCompensationCalculator $calculator,
    ) {}

    #[NoReturn]
    public function getYearOverview(string $employee)
    {
        $employeeTransport = $this->employeeRepository->search($employee);
        if (empty($employeeTransport)) {
            throw new \Exception("The employee is not known in the system");
        }

        $this->csvBuilder->build(
            $employeeTransport,
            $this->calculator->calculate($employeeTransport, (int) date('Y'))
        );
    }

    public function showEmployeeForm(string $template)
    {
        $employees = $this->employeeRepository->getEmployees();
        $employeeOptions = '';
        foreach ($employees as $employee) {
            $employeeOptions .= '<option value="' . $employee->getEmployee() . '">' . $employee->getEmployee() . '</option>';
        }

        ob_start();
        require_once $template;
        $templateString = ob_get_clean();

        echo str_replace('{{{employeeOptions}}}', $employeeOptions, $templateString);
    }
}
