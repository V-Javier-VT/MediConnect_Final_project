const pool = require('../database');

const deletePatient = async (req, res) => {
    try {
        const { id } = req.params;

        console.log(`🔍 Intentando eliminar paciente con ID: ${id}`);

        const [result] = await pool.query('DELETE FROM patients WHERE id = ?', [id]);

        if (result.affectedRows === 0) {
            console.log("⚠️ Paciente no encontrado.");
            return res.status(404).json({ message: 'Paciente no encontrado' });
        }

        console.log(`✅ Paciente con ID ${id} eliminado correctamente.`);
        res.status(200).json({ message: 'Paciente eliminado exitosamente' });
    } catch (error) {
        console.error('❌ Error al eliminar paciente:', error);
        res.status(500).json({ message: 'Error interno del servidor', error: error.message });
    }
};

module.exports = deletePatient;
