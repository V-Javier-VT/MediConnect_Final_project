const pool = require('../database');

const getPatients = async (req, res) => {
    try {
        const [rows] = await pool.query('SELECT * FROM patients');
        res.status(200).json(rows);
    } catch (error) {
        console.error('❌ Error al obtener pacientes:', error);
        res.status(500).json({ message: 'Error interno del servidor' });
    }
};

module.exports = getPatients;
