# Etapa de construcción
FROM golang:1.23.6-alpine AS builder

WORKDIR /app

# Copiar los archivos de go.mod y go.sum y descargar dependencias
COPY go.mod go.sum ./
RUN go mod download

# Copiar el código fuente
COPY . .

# Compilar la aplicación
RUN go build -o update-medical-history-service ./src/main.go

# Etapa final (imagen ligera para producción)
FROM alpine:latest

WORKDIR /app

# Copiar el binario desde la etapa de construcción
COPY --from=builder /app/update-medical-history-service .

# Dar permisos de ejecución al binario
RUN chmod +x /app/update-medical-history-service

# Exponer el puerto en el que corre el servicio
EXPOSE 7003

# Ejecutar la aplicación
CMD ["/app/update-medical-history-service"]
