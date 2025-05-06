<?php
namespace Application;

use Model\EmployeeTransport;
use Model\MonthCompensation;

/**
 * Calculates the compensations for each month of the current year
 */
class TransportCompensationCalculator
{
    private const MAP_TRANSPORT_COMPENSATION = [
        "bike"  => 50,
        "bus"   => 25,
        "train" => 10,
    ];

    /**
     * @param EmployeeTransport $employeeTransport
     *
     * @return array
     */
    public function calculate(
        EmployeeTransport $employeeTransport
    ): array {
        $transport = strtolower($employeeTransport->getTransport());
        $compensation = self::MAP_TRANSPORT_COMPENSATION[$transport];
        if ($transport === "bike") {
            $compensation *= 2;
        }

        $compensations = [];
        $previousDate = date_create(sprintf('first Day of January %s', date('Y')));
        if ($previousDate->format('D') !== 'Mon') {
            $previousDate = $previousDate->modify('first monday');
        }
        for ($month = 1; $month <= 12; $month++) {
            $monthName = date('F', mktime(0,0,0, $month, 1, 2000));
            $paymentDate = date_create(sprintf('Last Day of %s %s', $monthName, date('Y')))->add(new \DateInterval("P1D"));
            if ($paymentDate->format('D') !== 'Mon') {
                $paymentDate = $paymentDate->modify('first monday');
            }
            $weeks = $paymentDate->diff($previousDate)->days / 7;
            $compensations[$month] = new MonthCompensation(
                $paymentDate,
                $compensation *
                ceil($employeeTransport->getWeekHours() / 8) * 2 *
                $weeks *
                $employeeTransport->getDistance()
            );
            $previousDate = $paymentDate;
        }

        return $compensations;
    }
}
