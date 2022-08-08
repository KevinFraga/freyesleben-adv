const connect = require('./connection');

const getAll = async () => {
  const [data] = await connect.query('SELECT * FROM posts;');

  return data;
};

module.exports = {
  getAll,
};
