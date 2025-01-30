const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');
const pool = require('../database');

// Controlador para registrar un usuario
const registerUser = async (req, res) => {
    try {
        const { email, password } = req.body;

        // Validar datos
        if (!email || !password) {
            return res.status(400).json({ message: 'Email y contraseña son obligatorios' });
        }

        // Verificar si el usuario ya existe en la base de datos
        const existingUserQuery = await pool.query('SELECT * FROM users WHERE email = $1', [email]);
        if (existingUserQuery.rows.length > 0) {
            return res.status(400).json({ message: 'El usuario ya está registrado' });
        }

        // Encriptar la contraseña
        const hashedPassword = await bcrypt.hash(password, 10);

        // Insertar usuario en la base de datos
        await pool.query('INSERT INTO users (email, password) VALUES ($1, $2)', [email, hashedPassword]);

        res.status(201).json({ message: 'Usuario registrado exitosamente' });
    } catch (error) {
        console.error('❌ Error al registrar usuario:', error);
        res.status(500).json({ message: 'Error interno del servidor' });
    }
};

// Controlador para iniciar sesión
const loginUser = async (req, res) => {
    try {
        const { email, password } = req.body;

        // Validar datos
        if (!email || !password) {
            return res.status(400).json({ message: 'Email y contraseña son obligatorios' });
        }

        // Buscar usuario en la base de datos
        const userQuery = await pool.query('SELECT * FROM users WHERE email = $1', [email]);
        const user = userQuery.rows[0];

        if (!user) {
            return res.status(404).json({ message: 'Usuario no encontrado' });
        }

        // Comparar la contraseña ingresada con la almacenada
        const isPasswordValid = await bcrypt.compare(password, user.password);
        if (!isPasswordValid) {
            return res.status(401).json({ message: 'Credenciales inválidas' });
        }

        // Generar un token JWT
        const token = jwt.sign({ id: user.id }, process.env.JWT_SECRET, { expiresIn: '1h' });

        res.status(200).json({ message: 'Inicio de sesión exitoso', token });
    } catch (error) {
        console.error('❌ Error al iniciar sesión:', error);
        res.status(500).json({ message: 'Error interno del servidor' });
    }
};

module.exports = { registerUser, loginUser };

