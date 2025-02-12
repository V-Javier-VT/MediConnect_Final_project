package controllers

import (
	"create-medical-history-service/src/config"
	"create-medical-history-service/src/models"
	"net/http"

	"github.com/gin-gonic/gin"
)

// Crear historial médico
func CreateMedicalHistory(c *gin.Context) {
	var request struct {
		PatientName   string `json:"patient_name"`
		DoctorName    string `json:"doctor_name"`
		AppointmentID uint   `json:"appointment_id"`
		Diagnosis     string `json:"diagnosis"`
		Treatment     string `json:"treatment"`
	}

	if err := c.ShouldBindJSON(&request); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "Datos inválidos"})
		return
	}

	// Conectar a las bases de datos
	patientsDB := config.ConnectPatientsDB()
	appointmentsDB := config.ConnectAppointmentsDB()
	medicalHistoryDB := config.ConnectMedicalHistoryDB()

	// Buscar ID del paciente
	var patient struct {
		ID uint
	}
	if err := patientsDB.Raw("SELECT id FROM patients WHERE name = ?", request.PatientName).Scan(&patient).Error; err != nil {
		c.JSON(http.StatusNotFound, gin.H{"error": "Paciente no encontrado"})
		return
	}

	// Buscar ID del doctor
	var doctor struct {
		ID uint
	}
	if err := patientsDB.Raw("SELECT id FROM doctors WHERE name = ?", request.DoctorName).Scan(&doctor).Error; err != nil {
		c.JSON(http.StatusNotFound, gin.H{"error": "Doctor no encontrado"})
		return
	}

	// Validar que la cita existe
	var appointment struct {
		ID uint
	}
	if err := appointmentsDB.Raw("SELECT id FROM appointments WHERE id = ?", request.AppointmentID).Scan(&appointment).Error; err != nil {
		c.JSON(http.StatusNotFound, gin.H{"error": "Cita no encontrada"})
		return
	}

	// Crear historial médico
	newHistory := models.MedicalHistory{
		PatientID:     patient.ID,
		PatientName:   request.PatientName,
		DoctorID:      doctor.ID,
		DoctorName:    request.DoctorName,
		AppointmentID: appointment.ID,
		Diagnosis:     request.Diagnosis,
		Treatment:     request.Treatment,
	}

	if err := medicalHistoryDB.Create(&newHistory).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Error al crear historial médico"})
		return
	}

	c.JSON(http.StatusCreated, gin.H{"message": "Historial médico creado", "history": newHistory})
}
