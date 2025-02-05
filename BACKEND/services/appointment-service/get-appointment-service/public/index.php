<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/controllers/GetAppointmentController.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->setBasePath('/get-appointment-service');

$app->get('/appointments/get/{id}', [GetAppointmentController::class, 'getAppointment']);

$app->addErrorMiddleware(true, true, true);
$app->run();
?>
