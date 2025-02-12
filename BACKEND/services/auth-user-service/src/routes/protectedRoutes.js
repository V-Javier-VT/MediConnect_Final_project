const express = require('express');
const router = express.Router();
const authMiddleware = require('../middleware/authMiddleware');

router.get('/protected', authMiddleware, (req, res) => {
    res.json({ message: "Acceso permitido", user: req.user });
});

router.post('/create-patient', authMiddleware, async (req, res) => {
    // Lógica para crear un paciente
    res.json({ message: "Paciente creado exitosamente" });
});

router.post('/create-doctor', authMiddleware, async (req, res) => {
    // Lógica para crear un doctor
    res.json({ message: "Doctor creado exitosamente" });
});

router.post('/create-appointment', authMiddleware, async (req, res) => {
    // Lógica para crear una cita
    res.json({ message: "Cita creada exitosamente" });
});

module.exports = router;
