package routes

import (
	"delete-medical-history-service/controllers"

	"github.com/gin-gonic/gin"
)

func SetupRouter() *gin.Engine {
	r := gin.Default()

	// Ruta para eliminar una historia clínica
	r.DELETE("/medical-history/:id", controllers.DeleteMedicalHistory)

	return r
}
