require('dotenv').config();
const express = require('express');
const cors = require('cors');
const pool = require('./database');
const authRoutes = require('./routes/auth.routes');

const app = express();

// Middlewares
app.use(cors());
app.use(express.json());

// Verificar conexión a PostgreSQL al inicio
pool.connect((err, client, release) => {
    if (err) {
        console.error('❌ Error al conectar a PostgreSQL:', err);
    } else {
        console.log('✅ Conexión exitosa a PostgreSQL en Amazon RDS');
        release();
    }
});

// Rutas
app.use('/api/auth', authRoutes);

// Puerto
const PORT = process.env.PORT || 3001;
app.listen(PORT, () => {
    console.log(`Authentication Service ejecutándose en el puerto ${PORT}`);
});
