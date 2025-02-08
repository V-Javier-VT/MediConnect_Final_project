package config

import (
	"fmt"
	"log"
	"os"

	"github.com/joho/godotenv"
	"gorm.io/driver/mysql"
	"gorm.io/gorm"
)

// Variable global para la conexión a la base de datos
var DB *gorm.DB

func ConnectDB() {
	// Cargar variables de entorno
	err := godotenv.Load()
	if err != nil {
		log.Println("⚠️ Advertencia: No se pudo cargar el archivo .env, usando variables de entorno del sistema.")
	}

	// Construir DSN para la conexión
	dsn := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s?charset=utf8mb4&parseTime=True&loc=Local",
		os.Getenv("DB_USER"),
		os.Getenv("DB_PASSWORD"),
		os.Getenv("DB_HOST"),
		os.Getenv("DB_PORT"),
		os.Getenv("DB_NAME"),
	)

	// Intentar conectar a la base de datos
	db, err := gorm.Open(mysql.Open(dsn), &gorm.Config{})
	if err != nil {
		log.Fatalf("❌ Error al conectar con la base de datos: %v\nDSN: %s", err, dsn)
	}

	log.Println("✅ Conexión exitosa con la base de datos")
	DB = db
}
