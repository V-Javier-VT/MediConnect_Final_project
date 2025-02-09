# Usa una imagen oficial de Node.js como base
FROM node:18-alpine

# Establece el directorio de trabajo en el contenedor
WORKDIR /app

# Copia los archivos de configuración y dependencias
COPY package.json package-lock.json ./

# Instala las dependencias
RUN npm install --only=production

# Copia el resto del código fuente al contenedor
COPY . .

# Expone el puerto definido en el .env
EXPOSE 1001

# Comando para ejecutar la aplicación
CMD ["node", "index.js"]
