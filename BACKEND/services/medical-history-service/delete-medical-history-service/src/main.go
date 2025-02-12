package main

import (
	"delete-medical-history-service/src/routes"
	"fmt"
	"os"
)

func main() {
	port := os.Getenv("PORT")
	if port == "" {
		port = "7004"
	}

	r := routes.SetupRouter()
	fmt.Println("🗑️ Microservicio de eliminación de historial médico corriendo en el puerto:", port)
	r.Run(":" + port)
}
