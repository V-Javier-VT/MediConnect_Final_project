<?php
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../config/database.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AppointmentController {
    public function createAppointment(Request $request, Response $response) {
        $database = new Database();
        $db_pg = $database->connectPostgres();
        $db_mysql = $database->connectMySQL();

        $appointment = new Appointment($db_pg, $db_mysql);
        $data = json_decode($request->getBody(), true);

        if (!isset($data['doctor_name']) || !isset($data['patient_name']) || !isset($data['appointment_date']) || !isset($data['status'])) {
            $response->getBody()->write(json_encode(["message" => "Todos los campos son obligatorios"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $result = $appointment->createAppointment($data['doctor_name'], $data['patient_name'], $data['appointment_date'], $data['status']);

        if (isset($result["error"])) {
            $response->getBody()->write(json_encode(["message" => $result["error"]]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $response->getBody()->write(json_encode(["message" => "Cita creada con éxito", "id" => $result["id"]]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }
}
?>
