<?php
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../config/database.php';


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateAppointmentController {
    public function updateAppointment(Request $request, Response $response, array $args) {
        $database = new Database();
        $db_pg = $database->connectPostgres();
        $db_mysql = $database->connectMySQL();

        $appointment = new Appointment($db_pg, $db_mysql);
        $data = json_decode($request->getBody(), true);
        $appointment_id = $args['id'];

        // Llamamos a la función para actualizar la cita
        $result = $appointment->updateAppointment(
            $appointment_id,
            $data['doctor_name'] ?? null,
            $data['patient_name'] ?? null,
            $data['appointment_date'] ?? null,
            $data['status'] ?? null
        );

        if (isset($result["error"])) {
            $response->getBody()->write(json_encode(["message" => $result["error"]]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
?>
