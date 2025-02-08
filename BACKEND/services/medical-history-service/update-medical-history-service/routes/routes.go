package routes

import (
	"update-medical-history-service/controllers"

	"github.com/gin-gonic/gin"
)

func SetupRouter() *gin.Engine {
	r := gin.Default()

	// Ruta para actualizar una historia clínica
	r.PUT("/medical-history/:id", controllers.UpdateMedicalHistory)

	return r
}
