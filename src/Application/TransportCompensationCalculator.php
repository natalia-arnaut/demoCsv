<?php
namespace Application;

use Model\EmployeeTransport;
use Model\MonthCompensation;

/**
 * Calculates the compensations for each month of the current year
 */
class TransportCompensationCalculator
{
    public const BIKE  = 'bike';
    public const BUS   = 'bus';
    public const TRAIN = 'train';

    private const MAP_TRANSPORT_COMPENSATION = [
        self::BIKE  => 50,
        self::BUS   => 25,
        self::TRAIN => 10,
    ];

    /**
     * @param EmployeeTransport $employeeTransport
     *
     * @return MonthCompensation[]
     */
    public function calculate(
        EmployeeTransport $employeeTransport,
        int $year
    ): array {
        $transport = strtolower($employeeTransport->getTransport());
        $compensation = self::MAP_TRANSPORT_COMPENSATION[$transport];
        if ($transport === self::BIKE && $employeeTransport->getDistance() >= 5 && $employeeTransport->getDistance() <= 10) {
            $compensation *= 2;
        }

        $compensations = [];
        $previousDate = date_create(sprintf('first Day of January %s', $year));
        if ($previousDate->format('D') !== 'Mon') {
            $previousDate = $previousDate->modify('first monday');
        }
        for ($month = 1; $month <= 12; $month++) {
            $monthName = date('F', mktime(0,0,0, $month, 1, 2000));
            $paymentDate = date_create(sprintf('Last Day of %s %s', $monthName, $year))->add(new \DateInterval("P1D"));
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
