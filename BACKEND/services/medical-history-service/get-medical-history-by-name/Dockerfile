# Dockerfile

# Etapa de construcción
FROM golang:1.23.6-alpine AS builder

WORKDIR /app

# Copiar archivos y descargar dependencias
COPY go.mod go.sum ./
RUN go mod download

# Copiar el código fuente
COPY . .

# Compilar la aplicación
RUN go build -o get-medical-history-by-name ./src/main.go

# Etapa final (imagen ligera para ejecución)
FROM alpine:latest

WORKDIR /app

# Copiar el binario desde la etapa de construcción
COPY --from=builder /app/get-medical-history-by-name .

# Dar permisos de ejecución
RUN chmod +x /app/get-medical-history-by-name

# Exponer el puerto del servicio
EXPOSE 7005

# Ejecutar el binario
CMD ["/app/get-medical-history-by-name"]
