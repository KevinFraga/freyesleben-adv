const connect = require('./connection');

const registerUser = async (userData) => {
    const { name, email, password } = userData;

    const [_data] = await connect.execute(
        'INSERT INTO users VALUES(?, ?, ?)',
        [name, email, password]
    );

    return userData;
};

const getUsers = async () => {
    const [data] = await connect.execute('SELECT * FROM users');

    return data;
};

module.exports = {
    registerUser,
    getUsers
};
