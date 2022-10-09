const connect = require('./connection');

const registerFile = async ({
  userId,
  kind,
  fileName,
  filePath,
  contentType,
}) => {
  const [_data] = await connect.query(
    'INSERT INTO files (user_id, kind, name, path, content_type) VALUES (?, ?, ?, ?, ?);',
    [userId, kind, fileName, filePath, contentType]
  );

  return { fileName, filePath };
};

const registerProfilepic = async ({ userId, filePath, fileName }) => {
  const [_data] = await connect.query(
    'UPDATE users SET profilepic = ? WHERE id = ?;',
    [filePath, userId]
  );

  return { fileName, filePath };
};

const findFile = async (id, kind) => {
  const [data] = await connect.query(
    'SELECT name, path, content_type FROM files WHERE user_id = ? AND kind = ?;',
    [id, kind]
  );

  return data[0];
};

const getAllFiles = async (id) => {
  const [data] = await connect.query(
    'SELECT DISTINCT(name), kind, path, content_type FROM files WHERE user_id = ?;',
    [id]
  );

  return data;
};

module.exports = {
  registerFile,
  findFile,
  getAllFiles,
  registerProfilepic,
};
