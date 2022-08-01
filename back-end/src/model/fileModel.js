const connect = require('./connection');

const registerFile = async ({ userId, fileType, fileName, filePath }) => {
  const [_data] = await connect.query(
    'INSERT INTO files (user_id, type, name, path) VALUES (?, ?, ?, ?);',
    [userId, fileType, fileName, filePath]
  );

  return { fileName, filePath };
};

module.exports = {
  registerFile,
};
