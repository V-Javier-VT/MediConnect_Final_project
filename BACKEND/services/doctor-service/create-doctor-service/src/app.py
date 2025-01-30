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

# Modelo de datos correcto
class DoctorCreate(BaseModel):
    name: str
    specialty: str
    email: EmailStr

@app.post("/api/doctors")
def create_doctor(doctor: DoctorCreate, db: Session = Depends(get_db)):
    existing_doctor = db.query(Doctor).filter(Doctor.email == doctor.email).first()
    if existing_doctor:
        raise HTTPException(status_code=400, detail="El email ya está registrado")

    new_doctor = Doctor(
        name=doctor.name,
        specialty=doctor.specialty,
        email=doctor.email
    )
    
    db.add(new_doctor)
    db.commit()
    db.refresh(new_doctor)
    
    return {"message": "Doctor registrado exitosamente", "doctor": new_doctor}
