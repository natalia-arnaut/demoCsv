<?php
namespace Infrastructure;

use Application\Employees\EmployeeRepository;
use Model\EmployeeTransport;

class CsvEmployeeRepository implements EmployeeRepository
{
    public function search(string $name): ?EmployeeTransport {
        $fp = fopen(dirname(__DIR__) . '/database.csv', 'r');

        while ($line = fgetcsv($fp, null, ';')) {
            if ($line[0] == $name) {
                return new EmployeeTransport(
                    $name,
                    $line[1],
                    $line[2],
                    $line[3] * 8
                );
            }
        }
        fclose($fp);

        return null;
    }

    /**
     * @return EmployeeTransport[]
     */
    public function getEmployees(): array
    {
        $employees = [];

        $fp = fopen(dirname(__DIR__) . '/database.csv', 'r');
        fgetcsv($fp, null, ';'); // skip headers

        while ($line = fgetcsv($fp, null, ';')) {
            $employees[] = new EmployeeTransport(
                    $line[0],
                    $line[1],
                    $line[2],
                    floatval(str_replace(',', '.', $line[3])) * 8
                );
        }
        fclose($fp);

        return $employees;
    }
}
