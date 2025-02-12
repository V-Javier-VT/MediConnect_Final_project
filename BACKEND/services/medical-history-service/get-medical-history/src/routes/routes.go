package routes

import (
	"get-medical-history-service/src/controllers"

	"github.com/gin-gonic/gin"
)

func SetupRouter() *gin.Engine {
	r := gin.Default()

	r.GET("/medical-history", controllers.GetMedicalHistories)

	return r
}
