package main

import (
	"create-medical-history-service/src/config"
	"create-medical-history-service/src/routes"
	"fmt"
	"os"
)

func main() {
	config.ConnectDB()

	port := os.Getenv("PORT")
	if port == "" {
		port = "7002" // Puerto por defecto para este microservicio
	}

	fmt.Println("🩺 Microservicio de Obtener Historia Clínica corriendo en el puerto", port)

	r := routes.SetupRouter()
	r.Run(":" + port)
}
