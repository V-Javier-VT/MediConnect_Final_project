package models

import "time"

type MedicalHistory struct {
	ID            uint      `json:"id" gorm:"primaryKey"`
	PatientID     uint      `json:"patient_id"`
	PatientName   string    `json:"patient_name"`
	DoctorID      uint      `json:"doctor_id"`
	DoctorName    string    `json:"doctor_name"`
	AppointmentID uint      `json:"appointment_id"`
	Diagnosis     string    `json:"diagnosis"`
	Treatment     string    `json:"treatment"`
	DateCreated   time.Time `json:"date_created"`
}
