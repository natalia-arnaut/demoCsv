<?php
namespace Infrastructure;

use JetBrains\PhpStorm\NoReturn;
use Model\EmployeeTransport;
use Model\MonthCompensation;

class CsvBuilder
{
    #[NoReturn]
    public function build(
        EmployeeTransport $employeeTransport,
        array             $compensations
    ): array {
        $file = 'compensations' . $employeeTransport->getEmployee() . '.csv';
        header( "Content-Type: text/csv;charset=utf-8" );
        header( "Content-Disposition: attachment;filename=\"$file\"" );
        header("Pragma: no-cache");
        header("Expires: 0");

        $fp= fopen('php://output', 'w');

        fputcsv(
            $fp,
            [
                "Employee",
                "Transport",
                "Distance",
                "Compensation",
                "Payment Date",
            ],
            ";"
        );
        $employeeFields = [
            $employeeTransport->getEmployee(),
            strtoupper($employeeTransport->getTransport()),
            $employeeTransport->getDistance(),
        ];
        foreach ($compensations as $compensation)
        {
            fputcsv($fp, $this->getCsvFields($compensation, $employeeFields), ";");
        }
        fclose($fp);
        exit();
    }

    private function getCsvFields(MonthCompensation $compensation, array $fields): array {
        return array_merge($fields, [$compensation->getAmount() / 100, $compensation->getDate()->format('Y-m-d')]);
    }
}
