package models

type MedicalHistory struct {
	ID          int    `gorm:"primaryKey" json:"id"`
	PatientID   int    `json:"patient_id"`
	DoctorID    int    `json:"doctor_id"`
	Diagnosis   string `json:"diagnosis"`
	Treatment   string `json:"treatment"`
	DateCreated string `json:"date_created"`
}

// Configurar el nombre exacto de la tabla
func (MedicalHistory) TableName() string {
	return "medical_history" // Cambiar al nombre correcto en la base de datos
}
