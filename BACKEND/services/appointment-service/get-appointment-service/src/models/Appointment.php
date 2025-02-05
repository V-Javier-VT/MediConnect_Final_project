<?php
class Appointment {
    private $conn_pg;
    private $conn_mysql;
    private $table = "appointments";

    public function __construct($db_pg, $db_mysql) {
        $this->conn_pg = $db_pg;
        $this->conn_mysql = $db_mysql;
    }

    public function getAppointmentById($id) {
        // Obtener la cita desde PostgreSQL
        $query = "SELECT id, doctor_id, patient_id, appointment_date, status FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn_pg->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$appointment) {
            return ["error" => "Cita no encontrada"];
        }

        // Obtener el nombre del doctor desde MySQL
        $doctorQuery = "SELECT name FROM doctors WHERE id = :doctor_id";
        $stmtDoctor = $this->conn_mysql->prepare($doctorQuery);
        $stmtDoctor->bindParam(':doctor_id', $appointment['doctor_id'], PDO::PARAM_INT);
        $stmtDoctor->execute();
        $doctor = $stmtDoctor->fetch(PDO::FETCH_ASSOC);

        if ($doctor) {
            $appointment['doctor_name'] = $doctor['name'];
        } else {
            $appointment['doctor_name'] = "Desconocido";
        }

        // Obtener el nombre del paciente desde MySQL
        $patientQuery = "SELECT name FROM patients WHERE id = :patient_id";
        $stmtPatient = $this->conn_mysql->prepare($patientQuery);
        $stmtPatient->bindParam(':patient_id', $appointment['patient_id'], PDO::PARAM_INT);
        $stmtPatient->execute();
        $patient = $stmtPatient->fetch(PDO::FETCH_ASSOC);

        if ($patient) {
            $appointment['patient_name'] = $patient['name'];
        } else {
            $appointment['patient_name'] = "Desconocido";
        }

        return $appointment;
    }
}
?>
