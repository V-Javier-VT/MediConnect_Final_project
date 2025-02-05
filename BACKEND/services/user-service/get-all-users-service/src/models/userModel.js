const db = require('./db');

const User = {
    async getAllUsers() {
        try {
            const [rows] = await db.execute("SELECT id, name, email, role FROM users");
            if (rows.length === 0) {
                return { message: "No hay usuarios registrados" };
            }
            return rows;
        } catch (error) {
            console.error("Error obteniendo usuarios:", error);
            return { error: "No se pudo obtener la lista de usuarios" };
        }
    }
};

module.exports = User;
