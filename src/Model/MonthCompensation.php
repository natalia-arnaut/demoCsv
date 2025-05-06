<?php
namespace Model;

use DateTime;

class MonthCompensation
{
    public function __construct(
            private readonly DateTime $date,
            private readonly int      $amount
    ) {

    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }
}
