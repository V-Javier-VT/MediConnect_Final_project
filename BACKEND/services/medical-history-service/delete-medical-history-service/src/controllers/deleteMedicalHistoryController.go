package controllers

import (
	"delete-medical-history-service/src/config"
	"delete-medical-history-service/src/models"
	"net/http"

	"github.com/gin-gonic/gin"
)

// DeleteMedicalHistory elimina un historial médico por ID
func DeleteMedicalHistory(c *gin.Context) {
	db := config.ConnectMedicalHistoryDB()
	defer config.CloseDB(db)

	id := c.Param("id")
	var medicalHistory models.MedicalHistory

	// Buscar el historial médico por ID
	if err := db.First(&medicalHistory, id).Error; err != nil {
		c.JSON(http.StatusNotFound, gin.H{"error": "Historial médico no encontrado"})
		return
	}

	// Eliminar el historial médico
	if err := db.Delete(&medicalHistory).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Error al eliminar el historial médico"})
		return
	}

	c.JSON(http.StatusOK, gin.H{"message": "Historial médico eliminado exitosamente"})
}
