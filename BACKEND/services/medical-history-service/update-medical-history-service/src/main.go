package main

import (
	"fmt"
	"os"

	"update-medical-history-service/src/routes"
)

func main() {
	port := os.Getenv("PORT")
	if port == "" {
		port = "7003"
	}

	r := routes.SetupRouter()

	fmt.Println("🚀 Microservicio de actualización de historial médico corriendo en el puerto:", port)
	r.Run(":" + port)
}
