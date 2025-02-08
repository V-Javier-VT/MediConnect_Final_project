# Usar la imagen de Go
FROM golang:1.19

# Definir el directorio de trabajo
WORKDIR /app

# Copiar los archivos
COPY . .

# Descargar dependencias
RUN go mod tidy

# Compilar el código
RUN go build -o update-medical-history-service src/main.go

# Exponer el puerto
EXPOSE 7003

# Ejecutar la aplicación
CMD ["/app/update-medical-history-service"]
