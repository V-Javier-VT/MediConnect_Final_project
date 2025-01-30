const pool = require('../database');

const createPatient = async (req, res) => {
    try {
        const { name, age, gender, email } = req.body;

        if (!name || !age || !gender || !email) {
            return res.status(400).json({ message: 'Todos los campos son obligatorios' });
        }

        const [result] = await pool.query('INSERT INTO patients (name, age, gender, email) VALUES (?, ?, ?, ?)', 
                                          [name, age, gender, email]);

        res.status(201).json({ message: 'Paciente creado exitosamente', patientId: result.insertId });
    } catch (error) {
        console.error('❌ Error al crear paciente:', error);
        res.status(500).json({ message: 'Error interno del servidor', error: error.message });
    }
};

module.exports = createPatient;
