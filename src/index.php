<?php

require_once __DIR__ . '/imports.php';

use Application\TransportCompensationCalculator;
use Infrastructure\Controller;
use Infrastructure\CsvBuilder;
use Infrastructure\CsvEmployeeRepository;

$controller = new Controller(new CsvBuilder(), new CsvEmployeeRepository(), new TransportCompensationCalculator());
if (!empty($_POST) && array_key_exists('employee', $_POST)) {
    $controller->getYearOverview($_POST['employee']);
    // exit runs after the csv build
}

$controller->showEmployeeForm(__DIR__ . '/Frontend/theform.html');
