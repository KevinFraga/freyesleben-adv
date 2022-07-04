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

const getUserByEmail = async (userEmail) => {
    const { email } = userEmail;

    const [data] = await user.getUserByEmail(email);

    return data;
}


module.exports = {
    registerUser,
    getUsers,
    getUserByEmail
}
