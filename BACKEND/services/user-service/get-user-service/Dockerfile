# Usa una imagen base de Node.js
FROM node:18-alpine

# Establece el directorio de trabajo en el contenedor
WORKDIR /app

# Copia los archivos de la aplicación
COPY package.json package-lock.json ./

# Instala las dependencias
RUN npm install --omit=dev

# Copia el código fuente
COPY . .
COPY src /app/src

# Expone el puerto en el que correrá la aplicación
EXPOSE 6002

# Comando por defecto para ejecutar el servicio
CMD ["node", "src/index.js"]
