package controllers

import (
	"create-medical-history-service/src/config"
	"create-medical-history-service/src/models"
	"net/http"

	"github.com/gin-gonic/gin"
)

func GetMedicalHistoryByID(c *gin.Context) {
	id := c.Param("id")
	var medicalHistory models.MedicalHistory

	result := config.DB.First(&medicalHistory, id)

	if result.Error != nil {
		c.JSON(http.StatusNotFound, gin.H{"error": "Historia clínica no encontrada"})
		return
	}

	c.JSON(http.StatusOK, medicalHistory)
}
