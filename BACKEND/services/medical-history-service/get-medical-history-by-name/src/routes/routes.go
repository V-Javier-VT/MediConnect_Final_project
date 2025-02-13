package routes

import (
	"get-medical-history-by-name/src/controllers"

	"github.com/gin-gonic/gin"
)

func SetupRouter() *gin.Engine {
	r := gin.Default()
	r.GET("/medical-history/patient/:name", controllers.GetMedicalHistoryByName)
	return r
}
