package main

import (
	"create-medical-history-service/src/routes"
	"fmt"
	"os"
)

func main() {
	port := os.Getenv("PORT")
	if port == "" {
		port = "7001" // Puerto por defecto
	}

	r := routes.SetupRouter()

	fmt.Println("🚀 Microservicio de historial médico corriendo en el puerto:", port)
	r.Run(":" + port)
}
