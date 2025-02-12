package controllers

import (
	"net/http"
	"strconv"

	"github.com/gin-gonic/gin"
	"gorm.io/gorm"

	"update-medical-history-service/src/config"
	"update-medical-history-service/src/models"
)

// Función para actualizar un historial médico
func UpdateMedicalHistory(c *gin.Context) {
	db := config.ConnectMedicalHistoryDB()

	id, err := strconv.Atoi(c.Param("id"))
	if err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "ID inválido"})
		return
	}

	var history models.MedicalHistory
	if err := db.First(&history, id).Error; err != nil {
		if err == gorm.ErrRecordNotFound {
			c.JSON(http.StatusNotFound, gin.H{"error": "Historial médico no encontrado"})
		} else {
			c.JSON(http.StatusInternalServerError, gin.H{"error": "Error obteniendo historial médico"})
		}
		return
	}

	// Obtener datos del body
	if err := c.ShouldBindJSON(&history); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "Datos inválidos"})
		return
	}

	// Actualizar datos en la base
	if err := db.Save(&history).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Error actualizando historial médico"})
		return
	}

	c.JSON(http.StatusOK, gin.H{"message": "Historial médico actualizado correctamente", "data": history})
}
