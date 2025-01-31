<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Appointment.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

function createAppointment(Request $request, Response $response) {
    $db = new Database();
    $pg_conn = $db->connectPostgres(); // ✅ Método corregido
    $mysql_conn = $db->connectMySQL(); // ✅ Método corregido

    $appointment = new Appointment($pg_conn, $mysql_conn);
    $body = json_decode($request->getBody(), true); // Convertir el body en un array

    if (!isset($body['patient_id']) || !isset($body['doctor_id']) || !isset($body['appointment_date'])) {
        $response->getBody()->write(json_encode(["error" => "Datos incompletos"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    $appointment->patient_id = $body['patient_id'];
    $appointment->doctor_id = $body['doctor_id'];
    $appointment->appointment_date = $body['appointment_date'];
    $appointment->status = "scheduled";

    // Validar si el paciente y el doctor existen en MySQL
    $validation = $appointment->validatePatientAndDoctor();
    if ($validation !== true) {
        $response->getBody()->write(json_encode(["error" => $validation]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    // Crear la cita en PostgreSQL
    if ($appointment->create()) {
        $response->getBody()->write(json_encode(["message" => "Cita creada exitosamente"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    } else {
        $response->getBody()->write(json_encode(["error" => "Error al crear la cita"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
}
?>
