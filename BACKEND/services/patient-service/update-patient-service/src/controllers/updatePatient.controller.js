const pool = require('../database');

const updatePatient = async (req, res) => {
    try {
        const { id } = req.params;
        const { name, age, gender, email } = req.body;

        if (!name || !age || !gender || !email) {
            return res.status(400).json({ message: 'Todos los campos son obligatorios' });
        }

        const [result] = await pool.query(
            'UPDATE patients SET name = ?, age = ?, gender = ?, email = ? WHERE id = ?', 
            [name, age, gender, email, id]
        );

        if (result.affectedRows === 0) {
            return res.status(404).json({ message: 'Paciente no encontrado' });
        }

        res.status(200).json({ message: 'Paciente actualizado exitosamente' });
    } catch (error) {
        console.error('❌ Error al actualizar paciente:', error);
        res.status(500).json({ message: 'Error interno del servidor', error: error.message });
    }
};

module.exports = updatePatient;
