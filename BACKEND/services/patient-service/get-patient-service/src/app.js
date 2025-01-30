require('dotenv').config();
const express = require('express');
const cors = require('cors');
const getPatientById = require('./controllers/getPatientById.controller');

const app = express();
app.use(cors());
app.use(express.json());

// Ruta para obtener un paciente por ID
app.get('/api/patients/:id', getPatientById);

const PORT = process.env.PORT || 3004;
app.listen(PORT, () => {
    console.log(`🚀 Get Patient By ID Service ejecutándose en el puerto ${PORT}`);
});
