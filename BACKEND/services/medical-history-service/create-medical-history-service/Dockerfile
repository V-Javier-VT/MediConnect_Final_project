# Imagen base con Go
FROM golang:1.20-alpine

# Establecer el directorio de trabajo dentro del contenedor
WORKDIR /app

# Copiar archivos del proyecto al contenedor
COPY . .

# Descargar dependencias y compilar la aplicación
RUN go mod tidy && go build -o main .

# Exponer el puerto definido en el .env
EXPOSE 7001

# Comando para ejecutar la aplicación
CMD ["./main"]
