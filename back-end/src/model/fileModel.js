const connect = require('./connection');

const registerFile = async ({ userId, fileType, fileName, filePath }) => {
  const [_data] = await connect.query(
    'INSERT INTO files (user_id, type, name, path) VALUES (?, ?, ?, ?);',
    [userId, fileType, fileName, filePath]
  );

  return { fileName, filePath };
};

const findFile = async (id, fileType) => {
  const [data] = await connect.query(
    'SELECT name, path FROM files WHERE user_id = ? AND type = ?;',
    [id, fileType]
  );

  return data;
}

module.exports = {
  registerFile,
  findFile,
};
