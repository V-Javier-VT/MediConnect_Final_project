const db = require('./db');

const User = {
    async deleteUser(user_id) {
        try {
            const [result] = await db.execute(
                "DELETE FROM users WHERE id = ?",
                [user_id]
            );

            if (result.affectedRows === 0) {
                return { error: "Usuario no encontrado" };
            }

            return { message: "Usuario eliminado exitosamente" };
        } catch (error) {
            console.error("Error eliminando usuario:", error);
            return { error: "No se pudo eliminar el usuario" };
        }
    }
};

module.exports = User;
