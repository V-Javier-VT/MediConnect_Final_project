<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/controllers/AppointmentController.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->setBasePath('/create-appointment-service');

$app->post('/appointments/create', [AppointmentController::class, 'createAppointment']);

$app->addErrorMiddleware(true, true, true);
$app->run();
?>
