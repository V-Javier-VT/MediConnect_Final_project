const User = require('../models/userModel');

exports.updateUser = async (req, res) => {
    const { id } = req.params;
    const { name, email, role } = req.body;

    if (!id || !name || !email || !role) {
        return res.status(400).json({ message: "Todos los campos son obligatorios" });
    }

    const result = await User.updateUser(id, name, email, role);

    if (result.error) {
        return res.status(404).json({ message: result.error });
    }

    res.status(200).json(result);
};
