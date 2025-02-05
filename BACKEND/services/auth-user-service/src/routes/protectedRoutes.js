const express = require('express');
const router = express.Router();
const authMiddleware = require('../middleware/authMiddleware');

// Ruta protegida solo accesible con un token válido
router.get('/protected', authMiddleware, (req, res) => {
    res.json({ message: "Acceso permitido", user: req.user });
});

module.exports = router;
