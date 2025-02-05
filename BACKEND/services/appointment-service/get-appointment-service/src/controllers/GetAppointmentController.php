<?php
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../config/database.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetAppointmentController {
    public function getAppointment(Request $request, Response $response, array $args) {
        $database = new Database();
        $db_pg = $database->connectPostgres();
        $db_mysql = $database->connectMySQL();

        $appointment = new Appointment($db_pg, $db_mysql);
        $appointmentData = $appointment->getAppointmentById($args['id']);

        if (isset($appointmentData["error"])) {
            $response->getBody()->write(json_encode(["message" => $appointmentData["error"]]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        $response->getBody()->write(json_encode($appointmentData));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
?>
