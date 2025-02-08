package main

import (
	"delete-medical-history-service/config"
	"delete-medical-history-service/routes"
	"fmt"
	"os"
)

func main() {
	config.ConnectDB()

	port := os.Getenv("PORT")
	if port == "" {
		port = "7003"
	}

	fmt.Println("🚀 Microservicio de Eliminar Historia Clínica corriendo en el puerto", port)
	r := routes.SetupRouter()
	r.Run(":" + port)
}
