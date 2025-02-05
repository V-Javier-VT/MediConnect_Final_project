<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

require_once __DIR__ . '/../src/controllers/DeleteAppointmentController.php';

$app = AppFactory::create();
$app->setBasePath('/delete-appointment-service');

$app->delete('/appointments/delete/{id}', [DeleteAppointmentController::class, 'deleteAppointment']);

$app->addErrorMiddleware(true, true, true);
$app->run();
?>
