package controllers

import (
	"get-medical-history-service/src/config"
	"get-medical-history-service/src/models"
	"log"
	"net/http"

	"github.com/gin-gonic/gin"
)

func GetMedicalHistories(c *gin.Context) {
	// Conectar a las bases de datos
	medicalDB := config.ConnectMedicalHistoryDB()
	patientsDB := config.ConnectPatientsDB()
	appointmentsDB := config.ConnectAppointmentsDB()

	var histories []models.MedicalHistory

	// Obtener todos los historiales médicos
	if err := medicalDB.Find(&histories).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Error obteniendo historiales médicos"})
		return
	}

	// Enriquecer con datos de pacientes y citas
	for i, history := range histories {
		// Obtener nombre del paciente
		var patient struct {
			Name string `json:"name"`
		}
		if err := patientsDB.Raw("SELECT name FROM patients WHERE id = ?", history.PatientID).Scan(&patient).Error; err != nil {
			log.Println("Error obteniendo paciente:", err)
		} else {
			histories[i].PatientName = patient.Name
		}

		// Obtener nombre del doctor
		var doctor struct {
			Name string `json:"name"`
		}
		if err := patientsDB.Raw("SELECT name FROM doctors WHERE id = ?", history.DoctorID).Scan(&doctor).Error; err != nil {
			log.Println("Error obteniendo doctor:", err)
		} else {
			histories[i].DoctorName = doctor.Name
		}

		// Obtener detalles de la cita
		var appointment struct {
			AppointmentDate string `json:"appointment_date"`
			Status          string `json:"status"`
		}
		if err := appointmentsDB.Raw("SELECT appointment_date, status FROM appointments WHERE id = ?", history.AppointmentID).Scan(&appointment).Error; err != nil {
			log.Println("Error obteniendo cita:", err)
		}

	}

	c.JSON(http.StatusOK, histories)
}
