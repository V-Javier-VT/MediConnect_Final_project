const mysql = require('mysql2');
require('dotenv').config();

// Configuración de conexión a MySQL en Amazon RDS
const pool = mysql.createPool({
    host: process.env.MYSQL_HOST,
    port: process.env.MYSQL_PORT,
    user: process.env.MYSQL_USER,
    password: process.env.MYSQL_PASSWORD.trim(),
    database: process.env.MYSQL_DATABASE,
    waitForConnections: true,
    connectionLimit: 10,
    queueLimit: 0
}).promise(); // ⚠️ IMPORTANTE: Convertir en objeto de Promesas

// Verificar conexión
pool.getConnection()
    .then(connection => {
        console.log('✅ Conectado a MySQL en Amazon RDS');
        connection.release();
    })
    .catch(err => {
        console.error('❌ Error al conectar a MySQL:', err);
    });

module.exports = pool;
