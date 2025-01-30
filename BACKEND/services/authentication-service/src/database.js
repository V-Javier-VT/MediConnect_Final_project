const { Pool } = require('pg');
require('dotenv').config();

// Verificar que las variables de entorno se carguen correctamente
if (!process.env.PG_PASSWORD) {
    console.error("❌ ERROR: La variable PG_PASSWORD no está definida en .env");
    process.exit(1);
}

// Configuración del pool de conexiones a PostgreSQL en AWS RDS
const pool = new Pool({
    host: process.env.PG_HOST,
    port: process.env.PG_PORT,
    user: process.env.PG_USER,
    password: process.env.PG_PASSWORD.trim(),  // Evitar espacios en blanco
    database: process.env.PG_DATABASE,
    ssl: process.env.PG_SSL === "true" ? { rejectUnauthorized: false } : false
});

pool.on('connect', () => {
    console.log('✅ Conectado a PostgreSQL en Amazon RDS sin SSL');
});

pool.on('error', (err) => {
    console.error('❌ Error en la conexión con PostgreSQL:', err);
});

module.exports = pool;
