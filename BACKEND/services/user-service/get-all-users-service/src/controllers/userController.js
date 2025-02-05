const User = require('../models/userModel');

exports.getAllUsers = async (req, res) => {
    const result = await User.getAllUsers();

    if (result.error) {
        return res.status(500).json({ message: result.error });
    }

    res.status(200).json(result);
};
