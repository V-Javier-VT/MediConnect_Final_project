package controllers

import (
	"get-medical-history-by-name/src/config"
	"get-medical-history-by-name/src/models"
	"net/http"

	"github.com/gin-gonic/gin"
)

func GetMedicalHistoryByName(c *gin.Context) {
	name := c.Param("name")
	db := config.ConnectMedicalHistoryDB()
	var histories []models.MedicalHistory

	if err := db.Where("patient_name = ?", name).Find(&histories).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Error obteniendo historiales médicos"})
		return
	}

	c.JSON(http.StatusOK, histories)
}
