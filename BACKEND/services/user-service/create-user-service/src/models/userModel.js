const db = require('./db');
const bcrypt = require('bcryptjs');

const User = {
    async createUser(name, email, password, role, reference_id) {
        try {
            const hashedPassword = await bcrypt.hash(password, 10);

            const [result] = await db.execute(
                "INSERT INTO users (name, email, password, role, reference_id) VALUES (?, ?, ?, ?, ?)",
                [name, email, hashedPassword, role, reference_id]
            );

            return { id: result.insertId, message: "Usuario creado exitosamente" };
        } catch (error) {
            console.error("Error creando usuario:", error);
            return { error: "No se pudo crear el usuario" };
        }
    },

    async getUserByEmail(email) {
        try {
            const [rows] = await db.execute("SELECT * FROM users WHERE email = ?", [email]);
            return rows.length > 0 ? rows[0] : null;
        } catch (error) {
            console.error("Error obteniendo usuario:", error);
            return null;
        }
    }
};

module.exports = User;
