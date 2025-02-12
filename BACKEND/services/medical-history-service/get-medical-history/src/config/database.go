package config

import (
	"fmt"
	"log"
	"os"

	"github.com/joho/godotenv"
	"gorm.io/driver/mysql"
	"gorm.io/driver/postgres"
	"gorm.io/gorm"
)

// Carga las variables de entorno del archivo .env
func LoadEnv() {
	err := godotenv.Load()
	if err != nil {
		log.Println("⚠️ Advertencia: No se pudo cargar el archivo .env, usando variables de entorno del sistema.")
	}
}

// Conexión a la base de datos de historiales médicos (MariaDB)
func ConnectMedicalHistoryDB() *gorm.DB {
	LoadEnv()

	dsn := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s?charset=utf8mb4&parseTime=True&loc=Local",
		os.Getenv("DB_USER"),
		os.Getenv("DB_PASSWORD"),
		os.Getenv("DB_HOST"),
		os.Getenv("DB_PORT"),
		os.Getenv("DB_NAME"),
	)

	db, err := gorm.Open(mysql.Open(dsn), &gorm.Config{})
	if err != nil {
		log.Fatalf("❌ Error conectando a la base de datos de historiales médicos: %v", err)
	}

	fmt.Println("✅ Conectado a la base de datos de historiales médicos")

	sqlDB, err := db.DB()
	if err != nil {
		log.Fatalf("❌ Error obteniendo conexión SQL: %v", err)
	}

	// Prueba de conexión
	if err := sqlDB.Ping(); err != nil {
		log.Fatalf("❌ No se pudo hacer ping a la base de datos de historiales médicos: %v", err)
	}

	return db
}

// Conexión a la base de datos de pacientes (MySQL)
func ConnectPatientsDB() *gorm.DB {
	LoadEnv()

	dsn := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s?charset=utf8mb4&parseTime=True&loc=Local",
		os.Getenv("MYSQL_USER"),
		os.Getenv("MYSQL_PASSWORD"),
		os.Getenv("MYSQL_HOST"),
		os.Getenv("MYSQL_PORT"),
		os.Getenv("MYSQL_DATABASE"),
	)

	db, err := gorm.Open(mysql.Open(dsn), &gorm.Config{})
	if err != nil {
		log.Fatalf("❌ Error conectando a la base de datos de pacientes: %v", err)
	}

	fmt.Println("✅ Conectado a la base de datos de pacientes")

	sqlDB, err := db.DB()
	if err != nil {
		log.Fatalf("❌ Error obteniendo conexión SQL: %v", err)
	}

	// Prueba de conexión
	if err := sqlDB.Ping(); err != nil {
		log.Fatalf("❌ No se pudo hacer ping a la base de datos de pacientes: %v", err)
	}

	return db
}

// Conexión a la base de datos de citas (PostgreSQL)
func ConnectAppointmentsDB() *gorm.DB {
	LoadEnv()

	dsn := fmt.Sprintf("host=%s user=%s password=%s dbname=%s port=%s sslmode=disable",
		os.Getenv("PG_HOST"),
		os.Getenv("PG_USER"),
		os.Getenv("PG_PASSWORD"),
		os.Getenv("PG_DATABASE"),
		os.Getenv("PG_PORT"),
	)

	db, err := gorm.Open(postgres.Open(dsn), &gorm.Config{})
	if err != nil {
		log.Fatalf("❌ Error conectando a la base de datos de citas: %v", err)
	}

	fmt.Println("✅ Conectado a la base de datos de citas")

	sqlDB, err := db.DB()
	if err != nil {
		log.Fatalf("❌ Error obteniendo conexión SQL: %v", err)
	}

	// Prueba de conexión
	if err := sqlDB.Ping(); err != nil {
		log.Fatalf("❌ No se pudo hacer ping a la base de datos de citas: %v", err)
	}

	return db
}
