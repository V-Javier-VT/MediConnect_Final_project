<?php
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../config/database.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DeleteAppointmentController {
    public function deleteAppointment(Request $request, Response $response, array $args) {
        $database = new Database();
        $db_pg = $database->connectPostgres();

        $appointment = new Appointment($db_pg);
        $appointment_id = $args['id'];

        $result = $appointment->deleteAppointment($appointment_id);

        if (isset($result["error"])) {
            $response->getBody()->write(json_encode(["message" => $result["error"]]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
?>
