# Utiliza una imagen base ligera de Go
FROM golang:1.23.6

# Establecer el directorio de trabajo dentro del contenedor
WORKDIR /app

# Copiar los archivos del proyecto al contenedor
COPY go.mod go.sum ./
RUN go mod download

# Copiar el resto del código fuente del microservicio
COPY . .

# Compilar la aplicación
RUN go build -o delete-medical-history-service ./src/main.go

# Especificar el puerto en el que corre la aplicación
EXPOSE 7004

# Configurar las variables de entorno
ENV PORT=7004

# Ejecutar la aplicación
CMD ["/app/delete-medical-history-service"]
