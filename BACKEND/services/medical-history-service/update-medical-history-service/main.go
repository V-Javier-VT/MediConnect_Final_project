package main

import (
	"fmt"
	"os"
	"update-medical-history-service/config"
	"update-medical-history-service/routes"
)

func main() {
	config.ConnectDB()

	port := os.Getenv("PORT")
	if port == "" {
		port = "7003"
	}

	fmt.Println("🚀 Microservicio de Actualizar Historia Clínica corriendo en el puerto", port)
	r := routes.SetupRouter()
	r.Run(":" + port)
}
