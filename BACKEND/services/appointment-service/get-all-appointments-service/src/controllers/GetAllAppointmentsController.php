<?php
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../config/database.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetAllAppointmentsController {
    public function getAllAppointments(Request $request, Response $response) {
        $database = new Database();
        $db_pg = $database->connectPostgres();
        $db_mysql = $database->connectMySQL();

        $appointment = new Appointment($db_pg, $db_mysql);
        $appointments = $appointment->getAllAppointments();

        $response->getBody()->write(json_encode($appointments));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
?>
