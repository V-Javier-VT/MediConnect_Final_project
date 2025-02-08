package main

import (
	"fmt"
	"os"

	"create-medical-history-service/src/config"
	"create-medical-history-service/src/routes"
)

func main() {
	config.ConnectDB()

	port := os.Getenv("PORT")
	if port == "" {
		port = "7001"
	}

	fmt.Println("🚑 Microservicio de Historia Clínica corriendo en el puerto", port)

	r := routes.SetupRouter()
	r.Run(":" + port)
}
