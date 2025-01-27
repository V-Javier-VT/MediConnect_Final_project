require('dotenv').config(); // Cargar variables de entorno desde .env
const express = require('express');
const cors = require('cors');
const pool = require('./database'); // Conexión a PostgreSQL
const authRoutes = require('./routes/auth.routes'); // Rutas de autenticación

// Inicializar la aplicación de Express
const app = express();

// Middlewares
app.use(cors()); // Habilitar CORS
app.use(express.json()); // Parsear cuerpos JSON

// Verificar conexión a la base de datos PostgreSQL
pool.connect((err, client, release) => {
    if (err) {
        console.error('Error al conectar a PostgreSQL:', err);
    } else {
        console.log('Conexión exitosa a PostgreSQL en Amazon RDS');
        release(); // Liberar el cliente
    }
});

// Rutas
app.use('/api/auth', authRoutes);

// Puerto
const PORT = process.env.PORT || 3001;
app.listen(PORT, () => {
    console.log(`Authentication Service ejecutándose en el puerto ${PORT}`);
});
