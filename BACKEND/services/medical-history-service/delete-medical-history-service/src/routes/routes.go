package routes

import (
	"delete-medical-history-service/src/controllers"

	"github.com/gin-gonic/gin"
)

// Configurar rutas del microservicio
func SetupRouter() *gin.Engine {
	r := gin.Default()

	r.DELETE("/medical-history/:id", controllers.DeleteMedicalHistory)

	return r
}
