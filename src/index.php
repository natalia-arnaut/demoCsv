<?php

require_once __DIR__ . '/Application/EmployeeRepository.php';
require_once __DIR__ . '/Application/TransportCompensationCalculator.php';
require_once __DIR__ . '/Infrastructure/Controller.php';
require_once __DIR__ . '/Infrastructure/CsvBuilder.php';
require_once __DIR__ . '/Infrastructure/CsvEmployeeRepository.php';
require_once __DIR__ . '/Model/EmployeeTransport.php';
require_once __DIR__ . '/Model/MonthCompensation.php';


use Application\TransportCompensationCalculator;
use Infrastructure\Controller;
use Infrastructure\CsvBuilder;
use Infrastructure\CsvEmployeeRepository;

if (!empty($_POST) && array_key_exists('employee', $_POST)) {
    $controller = new Controller(new CsvBuilder(), new CsvEmployeeRepository(), new TransportCompensationCalculator());
    $controller->getYearOverview($_POST['employee']);
}
require_once __DIR__ . '/Frontend/theform.html';
