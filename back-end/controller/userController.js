const { user } = require('../service');

const registerUser = async (req, res) => {
    const userData = await user.registerUser(req.body);

    return res.status(201).json(userData);
};

const getUsers = async (_req, res) => {
    const userData = await user.getUsers();

    return res.status(200).send(userData);
}

module.exports = {
    registerUser,
    getUsers
};
