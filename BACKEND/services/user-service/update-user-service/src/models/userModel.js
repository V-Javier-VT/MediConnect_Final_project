const db = require('./db');

const User = {
    async updateUser(user_id, name, email, role) {
        try {
            const [result] = await db.execute(
                "UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?",
                [name, email, role, user_id]
            );

            if (result.affectedRows === 0) {
                return { error: "Usuario no encontrado o sin cambios" };
            }

            return { message: "Usuario actualizado exitosamente" };
        } catch (error) {
            console.error("Error actualizando usuario:", error);
            return { error: "No se pudo actualizar el usuario" };
        }
    }
};

module.exports = User;
