package main

import (
	"fmt"
	"get-medical-history-service/src/routes"
	"os"
)

func main() {
	port := os.Getenv("PORT")
	if port == "" {
		port = "7002" // Puerto por defecto para GET
	}

	r := routes.SetupRouter()

	fmt.Println("🚀 Microservicio de obtención de historial médico corriendo en el puerto:", port)
	r.Run(":" + port)
}
