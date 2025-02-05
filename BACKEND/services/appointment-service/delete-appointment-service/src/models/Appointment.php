<?php
class Appointment {
    private $conn_pg;
    private $table = "appointments";

    public function __construct($db_pg) {
        $this->conn_pg = $db_pg;
    }

    public function deleteAppointment($id) {
        // Verificar si la cita existe antes de eliminar
        $checkQuery = "SELECT id FROM " . $this->table . " WHERE id = :id";
        $stmtCheck = $this->conn_pg->prepare($checkQuery);
        $stmtCheck->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtCheck->execute();
        $appointment = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if (!$appointment) {
            return ["error" => "La cita con ID $id no existe"];
        }

        // Eliminar la cita
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn_pg->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return ["message" => "Cita eliminada correctamente"];
        }

        return ["error" => "Error al eliminar la cita"];
    }
}
?>
