FROM node:18-alpine

# Establecer el directorio de trabajo
WORKDIR /app

# Copiar package.json y package-lock.json
COPY package*.json ./

# Instalar dependencias
RUN npm install --only=production

# Copiar el resto de la aplicación
COPY . .

# Exponer el puerto del microservicio
EXPOSE 6005

# Comando por defecto para ejecutar la aplicación
CMD ["node", "src/index.js"]
