const connect = require('./connection');

const registerUser = async ({ name, email, password }) => {
  const [_data] = await connect.query(
    "INSERT INTO users (name, email, password, role, step) VALUES (?, ?, ?, 'user', 'Cadastro criado, favor enviar documentos.');",
    [name, email, password]
  );

  return { name, email };
};

const getUsers = async () => {
  const [data] = await connect.query('SELECT name, email FROM users;');

  return data;
};

const getUserByEmail = async (userEmail) => {
  const [data] = await connect.query(
    'SELECT * FROM users WHERE email = ?;',
    userEmail
  );

  return data[0];
};

module.exports = {
  registerUser,
  getUsers,
  getUserByEmail,
};
