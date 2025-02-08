package models

type MedicalHistory struct {
	ID          int    `json:"id"`
	PatientID   int    `json:"patient_id"`
	DoctorID    int    `json:"doctor_id"`
	Diagnosis   string `json:"diagnosis"`
	Treatment   string `json:"treatment"`
	DateCreated string `json:"date_created"`
}
