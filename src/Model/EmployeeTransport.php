<?php
namespace Model;

class EmployeeTransport
{
    public function __construct(
            private readonly string $employee,
            private readonly string $transport,
            private readonly int    $distance,
            private readonly int    $weekHours
    ) {

    }

    public function getEmployee(): string {
        return $this->employee;
    }

    public function getTransport(): string {
        return $this->transport;
    }

    public function getDistance(): string {
        return $this->distance;
    }

    public function getWeekHours(): string {
        return $this->weekHours;
    }
}
