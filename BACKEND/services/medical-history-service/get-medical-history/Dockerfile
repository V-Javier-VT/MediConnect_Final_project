# Usa una imagen base de Go
FROM golang:1.19

# Establece el directorio de trabajo dentro del contenedor
WORKDIR /app

# Copia los archivos de configuración y código fuente
COPY . .

# Descarga las dependencias
RUN go mod tidy

# Compila la aplicación
RUN go build -o main .

# Expone el puerto 7002
EXPOSE 7002

# Especifica las variables de entorno (pueden ser sobrescritas en docker-compose o runtime)
ENV PORT=7002
ENV DB_HOST=medicalhistorydb.cajdo4m5i9g7.us-east-1.rds.amazonaws.com
ENV DB_PORT=3333
ENV DB_USER=admin
ENV DB_PASSWORD=admin123
ENV DB_NAME=medicalhistorydb

# Comando de inicio
CMD ["/app/main"]
