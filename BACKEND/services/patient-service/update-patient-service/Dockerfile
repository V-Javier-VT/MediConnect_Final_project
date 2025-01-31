# Usa la imagen base de Node.js
FROM node:18

# Establece el directorio de trabajo dentro del contenedor
WORKDIR /app

# Copia los archivos de la aplicación
COPY package*.json ./

# Instala las dependencias de la aplicación
RUN npm install

# Copia el resto del código de la aplicación
COPY . .

# Expone el puerto del servicio
EXPOSE 3007

# Define las variables de entorno
ENV PORT=3007
ENV MYSQL_HOST=patient-db.cajdo4m5i9g7.us-east-1.rds.amazonaws.com
ENV MYSQL_PORT=3306
ENV MYSQL_USER=admin
ENV MYSQL_PASSWORD=admin123
ENV MYSQL_DATABASE=RDSMYSQL

# Comando para ejecutar la aplicación
CMD ["npm", "start"]
