require('dotenv').config();
const express = require('express');
const cors = require('cors');
const updatePatient = require('./controllers/updatePatient.controller');

const app = express();
app.use(cors());
app.use(express.json());

// Ruta para actualizar un paciente
app.put('/api/patients/:id', updatePatient);

const PORT = process.env.PORT || 3006;
app.listen(PORT, () => {
    console.log(`🚀 Update Patient Service ejecutándose en el puerto ${PORT}`);
});
