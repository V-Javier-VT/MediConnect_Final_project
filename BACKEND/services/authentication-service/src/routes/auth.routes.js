const express = require('express');
const { registerUser, loginUser } = require('../controllers/auth.controller');

const router = express.Router();

// Rutas para autenticación
router.post('/register', registerUser);
router.post('/login', loginUser);

module.exports = router;
