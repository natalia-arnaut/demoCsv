<?php
namespace test\Application;

use Application\TransportCompensationCalculator;
use Model\EmployeeTransport;
use Model\MonthCompensation;
use PHPUnit\Framework\TestCase;

require_once dirname(dirname(__DIR__)) . '/src/imports.php';

/**
 * Calculates the compensations for each month of the current year
 */
class TransportCompensationCalculatorTest extends TestCase
{
    private TransportCompensationCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new TransportCompensationCalculator();
    }

    /**
     * @dataProvider employeeTransportProvider
     *
     * @param EmployeeTransport $employeeTransport
     * @param array             $expectedCompensations
     */
    public function testCalculate(
        EmployeeTransport $employeeTransport, array $expectedCompensations
    ) {
        $compensations = $this->calculator->calculate($employeeTransport, 2025);

        $this->assertSame(
            $expectedCompensations,
            array_map(
                function(MonthCompensation $compensation) {
                    return [$compensation->getDate()->format('Y-m-d'), $compensation->getAmount()];
                },
                $compensations
            )
        );
    }

    protected function employeeTransportProvider(): array
    {
        $keys = range(1, 12);
        $dates = [
            '2025-02-03',
            '2025-03-03',
            '2025-04-07',
            '2025-05-05',
            '2025-06-02',
            '2025-07-07',
            '2025-08-04',
            '2025-09-01',
            '2025-10-06',
            '2025-11-03',
            '2025-12-01',
            '2026-01-05',
        ];

        return [
            [
                new EmployeeTransport('John', TransportCompensationCalculator::BIKE, 10, 32),
                array_combine(
                    $keys,
                    array_map( null,
                        $dates,
                        [32000, 32000, 40000, 32000, 32000, 40000, 32000, 32000, 40000, 32000, 32000, 40000],
                    )
                ),
            ],
            [
                new EmployeeTransport('Dave', TransportCompensationCalculator::BIKE, 25, 40),
                array_combine(
                    $keys,
                    array_map( null,
                        $dates,
                        [100000, 100000, 125000, 100000, 100000, 125000, 100000, 100000, 125000, 100000, 100000, 125000],
                    )
                ),
            ],
            [
                new EmployeeTransport('Thijs', TransportCompensationCalculator::BUS, 10, 40),
                array_combine(
                    $keys,
                    array_map( null,
                        $dates,
                        [10000, 10000, 12500, 10000, 10000, 12500, 10000, 10000, 12500, 10000, 10000, 12500],
                    )
                ),
            ],
            [
                new EmployeeTransport('Jessica', TransportCompensationCalculator::TRAIN, 10, 32),
                array_combine(
                    $keys,
                    array_map( null,
                        $dates,
                        [3200, 3200, 4000, 3200, 3200, 4000, 3200, 3200, 4000, 3200, 3200, 4000],
                    )
                ),
            ],
        ];
    }
}
