<?php
use Slim\App;

require_once __DIR__ . '/../controllers/AppointmentController.php';

return function (App $app) {
    $app->post('/api/appointments', 'createAppointment');
};
?>
