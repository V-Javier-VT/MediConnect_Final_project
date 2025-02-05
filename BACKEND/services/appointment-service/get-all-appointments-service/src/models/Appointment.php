<?php
class Appointment {
    private $conn_pg;
    private $conn_mysql;
    private $table = "appointments";

    public function __construct($db_pg, $db_mysql) {
        $this->conn_pg = $db_pg;
        $this->conn_mysql = $db_mysql;
    }

    public function getAllAppointments() {
        // Obtener todas las citas desde PostgreSQL
        $query = "SELECT id, doctor_id, patient_id, appointment_date, status FROM " . $this->table;
        $stmt = $this->conn_pg->prepare($query);
        $stmt->execute();
        $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$appointments) {
            return ["message" => "No hay citas registradas"];
        }

        // Obtener los nombres de los doctores y pacientes desde MySQL
        foreach ($appointments as &$appointment) {
            // Obtener el nombre del doctor desde MySQL
            $doctorQuery = "SELECT name FROM doctors WHERE id = :doctor_id";
            $stmtDoctor = $this->conn_mysql->prepare($doctorQuery);
            $stmtDoctor->bindParam(':doctor_id', $appointment['doctor_id'], PDO::PARAM_INT);
            $stmtDoctor->execute();
            $doctor = $stmtDoctor->fetch(PDO::FETCH_ASSOC);
            $appointment['doctor_name'] = $doctor ? $doctor['name'] : "Desconocido";

            // Obtener el nombre del paciente desde MySQL
            $patientQuery = "SELECT name FROM patients WHERE id = :patient_id";
            $stmtPatient = $this->conn_mysql->prepare($patientQuery);
            $stmtPatient->bindParam(':patient_id', $appointment['patient_id'], PDO::PARAM_INT);
            $stmtPatient->execute();
            $patient = $stmtPatient->fetch(PDO::FETCH_ASSOC);
            $appointment['patient_name'] = $patient ? $patient['name'] : "Desconocido";
        }

        return $appointments;
    }
}
?>
