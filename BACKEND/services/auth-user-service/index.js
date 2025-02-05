require('dotenv').config();
const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');
const authRoutes = require('./src/routes/authRoutes');
// Agregar rutas protegidas
//const protectedRoutes = require('./src/routes/protectedRoutes');

const app = express();
app.use(cors());
app.use(bodyParser.json());

// Agregar rutas de autenticación
app.use('/auth-user-service/auth', authRoutes);
// Agregar rutas protegidas
//app.use('/auth-user-service', protectedRoutes);

const PORT = process.env.PORT || 5012;
app.listen(PORT, () => console.log(`🚀 Servidor corriendo en http://localhost:${PORT}`));
