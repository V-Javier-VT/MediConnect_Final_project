const User = require('../models/userModel');

exports.createUser = async (req, res) => {
    const { name, email, password, role, reference_id } = req.body;

    if (!name || !email || !password || !role || !reference_id) {
        return res.status(400).json({ message: "Todos los campos son obligatorios" });
    }

    const result = await User.createUser(name, email, password, role, reference_id);

    if (result.error) {
        return res.status(500).json({ message: result.error });
    }

    res.status(201).json(result);
};
