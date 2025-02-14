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

# Etapa final (imagen liviana para ejecución)
FROM alpine:latest

WORKDIR /app

# Instalar dependencias necesarias para la ejecución
RUN apk --no-cache add ca-certificates

# Copiar el binario desde la etapa de construcción
COPY --from=builder /app/get-medical-history-by-name /app/get-medical-history-by-name

# Dar permisos de ejecución
RUN chmod +x /app/get-medical-history-by-name

# Exponer el puerto del servicio
EXPOSE 7002

# Definir el punto de entrada del contenedor
ENTRYPOINT ["/app/get-medical-history-by-name"]
