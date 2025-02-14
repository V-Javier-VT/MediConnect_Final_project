FROM node:18

# Establecer el directorio de trabajo
WORKDIR /app

# Copiar los archivos de la aplicación
COPY package*.json ./

# Instalar las dependencias
RUN npm install

# Copiar el resto de la aplicación
COPY . .

# Exponer el puerto del servicio
EXPOSE 6003

# Comando para ejecutar la aplicación
CMD ["node", "index.js"]
