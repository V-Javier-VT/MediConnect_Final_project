<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

require_once __DIR__ . '/../src/controllers/UpdateAppointmentController.php';

$app = AppFactory::create();
$app->setBasePath('/update-appointment-service');

$app->put('/appointments/update/{id}', [UpdateAppointmentController::class, 'updateAppointment']);

$app->addErrorMiddleware(true, true, true);
$app->run();
?>
