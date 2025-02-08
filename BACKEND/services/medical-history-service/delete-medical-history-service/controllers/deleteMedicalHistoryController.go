package controllers

import (
	"delete-medical-history-service/config"
	"delete-medical-history-service/models"
	"net/http"

	"github.com/gin-gonic/gin"
)

func DeleteMedicalHistory(c *gin.Context) {
	id := c.Param("id")

	var history models.MedicalHistory
	if err := config.DB.First(&history, id).Error; err != nil {
		c.JSON(http.StatusNotFound, gin.H{"error": "Historia clínica no encontrada"})
		return
	}

	config.DB.Delete(&history)
	c.JSON(http.StatusOK, gin.H{"message": "Historia clínica eliminada correctamente"})
}
