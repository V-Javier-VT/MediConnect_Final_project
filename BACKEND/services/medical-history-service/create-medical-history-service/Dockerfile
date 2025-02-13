# Usa una imagen oficial de Go como base
FROM golang:1.23

# Establece el directorio de trabajo dentro del contenedor
WORKDIR /app

# Copia los archivos del proyecto al contenedor
COPY . .

# Descarga las dependencias necesarias
RUN go mod tidy

# Compila la aplicación
RUN go build -o medical-history-service src/main.go

# Expone el puerto definido en el .env (7001 por defecto)
EXPOSE 7001

# Comando para ejecutar la aplicación
CMD ["/app/medical-history-service"]
