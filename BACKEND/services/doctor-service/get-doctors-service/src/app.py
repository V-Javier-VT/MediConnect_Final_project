from fastapi import FastAPI, Depends
from sqlalchemy.orm import Session
from pydantic import BaseModel
from typing import List
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

# Modelo de respuesta para listar médicos
class DoctorResponse(BaseModel):
    id: int
    name: str
    specialty: str
    email: str

    class Config:
        orm_mode = True

@app.get("/api/doctors", response_model=List[DoctorResponse])
def get_doctors(db: Session = Depends(get_db)):
    doctors = db.query(Doctor).all()
    return doctors
