# Imagen base
FROM golang:1.20

# Establecer el directorio de trabajo
WORKDIR /app

# Copiar todos los archivos al contenedor
COPY . .

# Descargar las dependencias
RUN go mod tidy

# Compilar el código
RUN go build -o delete-medical-history-service

# Exponer el puerto
EXPOSE 7004

# Comando para ejecutar el servicio
CMD [ "./delete-medical-history-service" ]
