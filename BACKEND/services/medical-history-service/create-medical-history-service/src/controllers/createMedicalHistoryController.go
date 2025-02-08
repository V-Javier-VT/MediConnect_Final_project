package controllers

import (
	"create-medical-history-service/src/config"
	"create-medical-history-service/src/models"
	"fmt"
	"net/http"

	"github.com/gin-gonic/gin"
)

func CreateMedicalHistory(c *gin.Context) {
	var medicalHistory models.MedicalHistory
	if err := c.ShouldBindJSON(&medicalHistory); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "Datos inválidos"})
		return
	}

	query := "INSERT INTO medical_history (patient_id, doctor_id, diagnosis, treatment) VALUES (?, ?, ?, ?)"
	result, err := config.DB.Exec(query, medicalHistory.PatientID, medicalHistory.DoctorID, medicalHistory.Diagnosis, medicalHistory.Treatment)
	if err != nil {
		fmt.Println("❌ Error insertando en la BD:", err)
		c.JSON(http.StatusInternalServerError, gin.H{"error": "No se pudo crear la historia clínica"})
		return
	}

	id, _ := result.LastInsertId()
	c.JSON(http.StatusOK, gin.H{"message": "Historia clínica creada", "id": id})
}
