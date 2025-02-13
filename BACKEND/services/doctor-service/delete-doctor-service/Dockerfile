# Usa una imagen oficial de Python
FROM python:3.10

# Establece el directorio de trabajo dentro del contenedor
WORKDIR /app

# Copia los archivos de requerimientos e instala dependencias
COPY src/requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Copia el resto del código fuente al contenedor
COPY . .

# Expone el puerto definido en el .env (4005)
EXPOSE 4005

# Comando para ejecutar la aplicación con Uvicorn
CMD ["python", "-m","uvicorn", "src.app:app", "--host", "0.0.0.0", "--port", "4005", "--reload"]
