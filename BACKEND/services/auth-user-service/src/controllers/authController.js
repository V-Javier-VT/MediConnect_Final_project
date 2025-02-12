const User = require('../models/userModel');
const jwt = require('jsonwebtoken');

exports.loginUser = async (req, res) => {
    const { email, password } = req.body;

    if (!email || !password) {
        return res.status(400).json({ message: "Email y contraseña son obligatorios" });
    }

    const user = await User.getUserByEmail(email);

    if (!user) {
        return res.status(401).json({ message: "Credenciales incorrectas" });
    }

    const isPasswordValid = await User.validatePassword(password, user.password);

    if (!isPasswordValid) {
        return res.status(401).json({ message: "Credenciales incorrectas" });
    }

    // Generar Token JWT
    const token = jwt.sign(
        { id: user.id, email: user.email },
        process.env.JWT_SECRET,
        { expiresIn: "1h" }
    );

    res.status(200).json({ message: "Autenticación exitosa", token });
};
