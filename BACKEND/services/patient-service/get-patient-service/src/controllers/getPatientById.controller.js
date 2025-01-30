const pool = require('../database');

const getPatientById = async (req, res) => {
    try {
        const { id } = req.params;
        console.log(`🔍 Buscando paciente con ID: ${id}`);

        const [rows] = await pool.query('SELECT * FROM patients WHERE id = ?', [id]);

        if (rows.length === 0) {
            console.log("⚠️ Paciente no encontrado.");
            return res.status(404).json({ message: 'Paciente no encontrado' });
        }

        console.log("✅ Paciente encontrado:", rows[0]);
        res.status(200).json(rows[0]);
    } catch (error) {
        console.error('❌ Error al obtener paciente:', error);
        res.status(500).json({ message: 'Error interno del servidor', error: error.message });
    }
};

module.exports = getPatientById;
