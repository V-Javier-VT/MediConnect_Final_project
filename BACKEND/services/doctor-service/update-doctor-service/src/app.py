from fastapi import FastAPI, Depends, HTTPException
from sqlalchemy.orm import Session
from pydantic import BaseModel, EmailStr
from .database import SessionLocal
from .models import Doctor

app = FastAPI()

# Dependencia para la base de datos
def get_db():
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()

# Modelo de entrada para actualizar un doctor
class DoctorUpdate(BaseModel):
    name: str
    specialty: str
    email: EmailStr

@app.put("/api/doctors/{doctor_id}")
def update_doctor(doctor_id: int, doctor: DoctorUpdate, db: Session = Depends(get_db)):
    existing_doctor = db.query(Doctor).filter(Doctor.id == doctor_id).first()
    if not existing_doctor:
        raise HTTPException(status_code=404, detail="Doctor no encontrado")

    # Verificar si el email ya está en uso por otro doctor
    if db.query(Doctor).filter(Doctor.email == doctor.email, Doctor.id != doctor_id).first():
        raise HTTPException(status_code=400, detail="El email ya está registrado por otro doctor")

    # Actualizar datos
    existing_doctor.name = doctor.name
    existing_doctor.specialty = doctor.specialty
    existing_doctor.email = doctor.email

    db.commit()
    db.refresh(existing_doctor)

    return {"message": "Doctor actualizado exitosamente", "doctor": existing_doctor}
