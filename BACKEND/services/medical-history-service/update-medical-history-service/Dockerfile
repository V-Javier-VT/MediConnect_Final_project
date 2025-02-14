# Etapa de construcción
FROM golang:1.23.6-alpine AS builder

WORKDIR /app

# Instalar dependencias necesarias para compilación en Alpine
RUN apk add --no-cache git

# Copiar archivos de módulos y descargar dependencias
COPY go.mod go.sum ./
RUN go mod download

# Copiar el código fuente
COPY . .

# Configurar variables para evitar dependencias C en Alpine
ENV CGO_ENABLED=0

# Compilar el binario
RUN go build -o update-medical-history-service ./src/main.go

# Etapa final (imagen liviana para producción)
FROM alpine:latest

WORKDIR /app

# Copiar el binario compilado desde la etapa anterior
COPY --from=builder /app/update-medical-history-service .

# Dar permisos de ejecución al binario
RUN chmod +x /app/update-medical-history-service

# Exponer el puerto del servicio
EXPOSE 7003

# Ejecutar el binario
CMD ["/app/update-medical-history-service"]
