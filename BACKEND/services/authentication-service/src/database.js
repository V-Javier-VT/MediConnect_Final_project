const { Pool } = require('pg');
require('dotenv').config();

// Configuración de conexión a PostgreSQL
const pool = new Pool({
    host: process.env.PG_HOST,
    port: process.env.PG_PORT,
    user: process.env.PG_USER,
    password: process.env.PG_PASSWORD,
    database: process.env.PG_DATABASE,
    ssl: {
        rejectUnauthorized: false, // Importante para conectarse a RDS
    },
});

pool.on('connect', () => {
    console.log('Conectado a PostgreSQL en Amazon RDS');
});

pool.on('error', (err) => {
    console.error('Error en la conexión con PostgreSQL:', err);
});

module.exports = pool;
