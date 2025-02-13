package main

import (
	"fmt"
	"get-medical-history-by-name/src/routes"
	"os"
)

func main() {
	port := os.Getenv("PORT")
	if port == "" {
		port = "7005" // Puerto por defecto para GET por nombre
	}

	r := routes.SetupRouter()

	fmt.Println("🩺 Microservicio de obtención de historial médico por nombre corriendo en el puerto:", port)
	r.Run(":" + port)
}
