package routes

import (
	"create-medical-history-service/src/controllers"

	"github.com/gin-gonic/gin"
)

func SetupRouter() *gin.Engine {
	r := gin.Default()
	r.POST("/medical-history", controllers.CreateMedicalHistory)
	return r
}
