const { user } = require('../service');

const registerUser = async (req, res) => {
    const userData = await user.registerUser(req.body);

    return res.status(201).json(userData);
};

module.exports = {
    registerUser
};
