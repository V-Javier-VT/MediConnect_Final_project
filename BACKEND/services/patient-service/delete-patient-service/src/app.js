require('dotenv').config();
const express = require('express');
const cors = require('cors');
const deletePatient = require('./controllers/deletePatient.controller');

const app = express();
app.use(cors());
app.use(express.json());

// Ruta para eliminar un paciente
app.delete('/api/patients/:id', deletePatient);

const PORT = process.env.PORT || 3008;
app.listen(PORT, () => {
    console.log(`🚀 Delete Patient Service ejecutándose en el puerto ${PORT}`);
});
