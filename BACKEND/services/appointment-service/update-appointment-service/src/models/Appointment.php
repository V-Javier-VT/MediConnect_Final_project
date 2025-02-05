<?php
class Appointment {
    private $conn_pg;
    private $conn_mysql;
    private $table = "appointments";

    public function __construct($db_pg, $db_mysql) {
        $this->conn_pg = $db_pg;
        $this->conn_mysql = $db_mysql;
    }

    public function updateAppointment($appointment_id, $doctor_name = null, $patient_name = null, $appointment_date = null, $status = null) {
        $updates = [];
        $params = [];

        // Si el doctor cambia, obtenemos su ID desde MySQL
        if ($doctor_name !== null) {
            $doctorQuery = "SELECT id FROM doctors WHERE name = :doctor_name";
            $stmtDoctor = $this->conn_mysql->prepare($doctorQuery);
            $stmtDoctor->bindParam(':doctor_name', $doctor_name);
            $stmtDoctor->execute();
            $doctor = $stmtDoctor->fetch(PDO::FETCH_ASSOC);

            if (!$doctor) {
                return ["error" => "El doctor '$doctor_name' no existe"];
            }
            $updates[] = "doctor_id = :doctor_id";
            $params[':doctor_id'] = $doctor['id'];
        }

        // Si el paciente cambia, obtenemos su ID desde MySQL
        if ($patient_name !== null) {
            $patientQuery = "SELECT id FROM patients WHERE name = :patient_name";
            $stmtPatient = $this->conn_mysql->prepare($patientQuery);
            $stmtPatient->bindParam(':patient_name', $patient_name);
            $stmtPatient->execute();
            $patient = $stmtPatient->fetch(PDO::FETCH_ASSOC);

            if (!$patient) {
                return ["error" => "El paciente '$patient_name' no existe"];
            }
            $updates[] = "patient_id = :patient_id";
            $params[':patient_id'] = $patient['id'];
        }

        // Si se actualiza la fecha de la cita
        if ($appointment_date !== null) {
            $updates[] = "appointment_date = :appointment_date";
            $params[':appointment_date'] = $appointment_date;
        }

        // Si se actualiza el estado de la cita
        if ($status !== null) {
            $updates[] = "status = :status";
            $params[':status'] = $status;
        }

        // Si no hay cambios, retornamos un error
        if (empty($updates)) {
            return ["error" => "No hay campos para actualizar"];
        }

        // Construcción de la consulta SQL
        $query = "UPDATE " . $this->table . " SET " . implode(", ", $updates) . " WHERE id = :id RETURNING id";
        $params[':id'] = $appointment_id;

        $stmt = $this->conn_pg->prepare($query);
        $stmt->execute($params);

        return ["message" => "Cita actualizada correctamente"];
    }
}
?>
