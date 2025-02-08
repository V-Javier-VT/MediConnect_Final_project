package routes

import (
	"create-medical-history-service/src/controllers"

	"github.com/gin-gonic/gin"
)

func SetupRouter() *gin.Engine {
	r := gin.Default()

	r.GET("/medical-history/:id", controllers.GetMedicalHistoryByID)

	return r
}
