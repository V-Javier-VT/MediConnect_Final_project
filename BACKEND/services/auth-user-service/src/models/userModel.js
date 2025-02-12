const db = require('./db');
const bcrypt = require('bcryptjs');

const User = {
    async getUserByEmail(email) {
        try {
            const [rows] = await db.execute("SELECT * FROM users WHERE email = ?", [email]);
            return rows.length > 0 ? rows[0] : null;
        } catch (error) {
            console.error("Error obteniendo usuario:", error);
            return null;
        }
    },

    async validatePassword(password, hashedPassword) {
        try {
            return await bcrypt.compare(password, hashedPassword);
        } catch (error) {
            console.error("Error validando contraseña:", error);
            return false;
        }
    }
};

module.exports = User;
