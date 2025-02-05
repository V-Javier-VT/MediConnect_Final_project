<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

require_once __DIR__ . '/../src/controllers/GetAllAppointmentsController.php';

$app = AppFactory::create();
$app->setBasePath('/get-all-appointments-service');

$app->get('/appointments', [GetAllAppointmentsController::class, 'getAllAppointments']);

$app->addErrorMiddleware(true, true, true);
$app->run();
?>
