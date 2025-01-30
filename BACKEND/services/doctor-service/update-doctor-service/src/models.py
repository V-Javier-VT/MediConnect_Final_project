from sqlalchemy import Column, Integer, String
from .database import Base

class Doctor(Base):
    __tablename__ = "doctors"

    id = Column(Integer, primary_key=True, index=True)
    name = Column(String(255), nullable=False)
    specialty = Column(String(255), nullable=False)
    email = Column(String(255), unique=True, nullable=False)
