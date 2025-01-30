from fastapi import FastAPI, Depends, HTTPException
from sqlalchemy.orm import Session
from src.database import SessionLocal
from .models import Doctor

app = FastAPI()

# Dependencia para la base de datos
def get_db():
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()

@app.delete("/api/doctors/{doctor_id}")
def delete_doctor(doctor_id: int, db: Session = Depends(get_db)):
    doctor = db.query(Doctor).filter(Doctor.id == doctor_id).first()
    if doctor is None:
        raise HTTPException(status_code=404, detail="Doctor no encontrado")

    db.delete(doctor)
    db.commit()

    return {"message": "Doctor eliminado exitosamente"}
