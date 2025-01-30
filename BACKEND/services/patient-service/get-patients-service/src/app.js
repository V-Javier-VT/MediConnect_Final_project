require('dotenv').config();
const express = require('express');
const cors = require('cors');
const getPatients = require('./controllers/getPatients.controller');

const app = express();
app.use(cors());
app.use(express.json());

// Ruta para obtener todos los pacientes
app.get('/api/patients', getPatients);

const PORT = process.env.PORT || 3003;
app.listen(PORT, () => {
    console.log(`🚀 Get Patients Service ejecutándose en el puerto ${PORT}`);
});
