<?php
class Appointment {
    private $pg_conn;
    private $mysql_conn;
    private $table = "appointments";

    public $id;
    public $patient_id;
    public $doctor_id;
    public $appointment_date;
    public $status;

    public function __construct($pg_db, $mysql_db) {
        $this->pg_conn = $pg_db;
        $this->mysql_conn = $mysql_db;
    }

    public function validatePatientAndDoctor() {
        // Verificar si el paciente existe en MySQL
        $patient_query = "SELECT id FROM patients WHERE id = :patient_id";
        $stmt = $this->mysql_conn->prepare($patient_query);
        $stmt->bindParam(":patient_id", $this->patient_id);
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            return "Paciente no encontrado en la base de datos.";
        }

        // Verificar si el doctor existe en MySQL
        $doctor_query = "SELECT id FROM doctors WHERE id = :doctor_id";
        $stmt = $this->mysql_conn->prepare($doctor_query);
        $stmt->bindParam(":doctor_id", $this->doctor_id);
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            return "Doctor no encontrado en la base de datos.";
        }

        return true;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (patient_id, doctor_id, appointment_date, status) 
                  VALUES (:patient_id, :doctor_id, :appointment_date, :status)";
        $stmt = $this->pg_conn->prepare($query);

        $stmt->bindParam(":patient_id", $this->patient_id);
        $stmt->bindParam(":doctor_id", $this->doctor_id);
        $stmt->bindParam(":appointment_date", $this->appointment_date);
        $stmt->bindParam(":status", $this->status);

        return $stmt->execute();
    }
}
?>
