<?php
class Appointment {
    private $conn_pg;
    private $conn_mysql;
    private $table = "appointments";

    public function __construct($db_pg, $db_mysql) {
        $this->conn_pg = $db_pg;
        $this->conn_mysql = $db_mysql;
    }

    public function createAppointment($doctor_name, $patient_name, $appointment_date, $status) {
        // Obtener el ID del doctor desde MySQL
        $doctorQuery = "SELECT id FROM doctors WHERE name = :doctor_name";
        $stmtDoctor = $this->conn_mysql->prepare($doctorQuery);
        $stmtDoctor->bindParam(':doctor_name', $doctor_name);
        $stmtDoctor->execute();
        $doctor = $stmtDoctor->fetch(PDO::FETCH_ASSOC);

        if (!$doctor) {
            return ["error" => "El doctor '$doctor_name' no existe"];
        }
        $doctor_id = $doctor['id'];

        // Obtener el ID del paciente desde MySQL
        $patientQuery = "SELECT id FROM patients WHERE name = :patient_name";
        $stmtPatient = $this->conn_mysql->prepare($patientQuery);
        $stmtPatient->bindParam(':patient_name', $patient_name);
        $stmtPatient->execute();
        $patient = $stmtPatient->fetch(PDO::FETCH_ASSOC);

        if (!$patient) {
            return ["error" => "El paciente '$patient_name' no existe"];
        }
        $patient_id = $patient['id'];

        // Insertar la cita en PostgreSQL
        $query = "INSERT INTO " . $this->table . " (doctor_id, patient_id, appointment_date, status) 
                  VALUES (:doctor_id, :patient_id, :appointment_date, :status) RETURNING id";
        $stmt = $this->conn_pg->prepare($query);
        
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->bindParam(':patient_id', $patient_id);
        $stmt->bindParam(':appointment_date', $appointment_date);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            return ["id" => $stmt->fetch(PDO::FETCH_ASSOC)['id']];
        }
        return ["error" => "Error al crear la cita"];
    }
}
?>
