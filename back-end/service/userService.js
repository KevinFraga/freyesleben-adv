const { user } = require('../model');

const registerUser = async ({ name, email, password }) => {
    const userData = {
        name,
        email,
        password
    };

    const resgister = await user.registerUser(userData);

    return resgister;
};

const getUsers = async () => await user.getUsers();

module.exports = {
    registerUser,
    getUsers
}
