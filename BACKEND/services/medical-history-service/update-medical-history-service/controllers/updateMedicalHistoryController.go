package controllers

import (
	"net/http"

	"update-medical-history-service/config"
	"update-medical-history-service/models"

	"github.com/gin-gonic/gin"
)

func UpdateMedicalHistory(c *gin.Context) {
	id := c.Param("id")
	var medicalHistory models.MedicalHistory

	// Buscar si la historia clínica existe
	if err := config.DB.First(&medicalHistory, id).Error; err != nil {
		c.JSON(http.StatusNotFound, gin.H{"error": "Historia clínica no encontrada"})
		return
	}

	// Bind del JSON enviado
	if err := c.ShouldBindJSON(&medicalHistory); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	// Guardar la actualización
	config.DB.Save(&medicalHistory)
	c.JSON(http.StatusOK, gin.H{"message": "Historia clínica actualizada", "data": medicalHistory})
}
