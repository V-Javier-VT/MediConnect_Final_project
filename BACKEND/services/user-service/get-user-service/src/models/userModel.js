const db = require('./db');

const User = {
    async getUserById(user_id) {
        try {
            const [rows] = await db.execute("SELECT * FROM users WHERE id = ?", [user_id]);
            if (rows.length === 0) {
                return { error: "Usuario no encontrado" };
            }
            return rows[0]; // Retornar la información del usuario
        } catch (error) {
            console.error("Error obteniendo usuario:", error);
            return { error: "No se pudo obtener el usuario" };
        }
    }
};

module.exports = User;
