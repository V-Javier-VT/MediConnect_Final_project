# Usar una imagen base de Node.js
FROM node:18-alpine

# Establecer el directorio de trabajo dentro del contenedor
WORKDIR /app

# Copiar los archivos de configuración y dependencias
COPY package.json package-lock.json ./

# Instalar dependencias
RUN npm install --omit=dev

# Copiar el resto del código fuente del microservicio
COPY . .

# Exponer el puerto del servicio
EXPOSE 3005

# Definir las variables de entorno
ENV NODE_ENV=production

# Ejecutar la aplicación
CMD ["node", "src/app.js"]
