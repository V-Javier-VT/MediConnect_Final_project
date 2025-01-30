require('dotenv').config();
const express = require('express');
const cors = require('cors');
const createPatient = require('./controllers/createPatient.controller');

const app = express();
app.use(cors());
app.use(express.json());

// Ruta para crear un paciente
app.post('/api/patients', createPatient);

const PORT = process.env.PORT || 3005;
app.listen(PORT, () => {
    console.log(`🚀 Create Patient Service ejecutándose en el puerto ${PORT}`);
});
