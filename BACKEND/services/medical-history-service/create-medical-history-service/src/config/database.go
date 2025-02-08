package config

import (
	"database/sql"
	"fmt"
	"log"
	"os"

	_ "github.com/go-sql-driver/mysql" // Driver compatible con MariaDB
	"github.com/joho/godotenv"
)

var DB *sql.DB

func ConnectDB() {
	err := godotenv.Load()
	if err != nil {
		log.Fatal("❌ Error cargando el archivo .env")
	}

	dbURL := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s?parseTime=true",
		os.Getenv("DB_USER"), os.Getenv("DB_PASSWORD"), os.Getenv("DB_HOST"),
		os.Getenv("DB_PORT"), os.Getenv("DB_NAME"))

	DB, err = sql.Open("mysql", dbURL) // MariaDB usa el driver de MySQL
	if err != nil {
		log.Fatal("❌ Error conectando a la base de datos:", err)
	}

	if err = DB.Ping(); err != nil {
		log.Fatal("❌ No se pudo establecer conexión con MariaDB")
	}

	fmt.Println("📌 Conexión exitosa a MariaDB en AWS RDS")
}
