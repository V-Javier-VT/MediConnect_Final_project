FROM python:3.10

# Establece el directorio de trabajo dentro del contenedor
WORKDIR /app

# Copia los archivos de requerimientos e instala dependencias
COPY src/requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Copia el resto del código fuente al contenedor
COPY . .

# Expone el puerto definido en el .env (4004)
EXPOSE 4004

# Comando para ejecutar la aplicación con Uvicorn
CMD ["uvicorn", "src.app:app", "--host", "0.0.0.0", "--port", "4004", "--reload"]
