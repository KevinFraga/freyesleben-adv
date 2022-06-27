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

module.exports = {
    registerUser
}
