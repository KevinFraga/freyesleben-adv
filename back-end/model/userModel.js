const connect = require('./connection');

const registerUser = async (userData) => {
    const { name, email, password } = userData;

    const values = [name, email, password];

    const [_data] = await connect.query(
        'INSERT INTO users (name, email, password) VALUES(?, ?, ?);',
        values
    );

    return userData;
};

const getUsers = async () => {
    const [data] = await connect.query('SELECT name, email FROM users;');

    return data;
};

module.exports = {
    registerUser,
    getUsers
};
