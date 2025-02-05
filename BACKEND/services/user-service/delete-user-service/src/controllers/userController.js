const User = require('../models/userModel');

exports.deleteUser = async (req, res) => {
    const { id } = req.params;

    if (!id) {
        return res.status(400).json({ message: "El ID del usuario es obligatorio" });
    }

    const result = await User.deleteUser(id);

    if (result.error) {
        return res.status(404).json({ message: result.error });
    }

    res.status(200).json(result);
};
