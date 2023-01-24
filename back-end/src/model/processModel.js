const connect = require('./connection');

const createProcess = async ({ userId, process }) => {
  const [_data] = await connect.query(
    "INSERT INTO userProcesses(user_id, process, step, stage, color, documentation) VALUES (?, ?, 'Processo iniciado, por favor envie os seus documentos para continuarmos.', 0, 'yellow', 0);",
    [userId, process]
  );

  return { message: 'Processo criado com sucesso.' };
};

const getProcesses = async () => {
  const [data] = await connect.query('SELECT name FROM processes;');

  return data;
};

const getProcessesByUser = async (id) => {
  const [data] = await connect.query(
    'SELECT process FROM userProcesses WHERE user_id = ?;',
    [id]
  );

  return data;
};

const findProcess = async ({ userId, process }) => {
  const [data] = await connect.query(
    'SELECT * FROM userProcesses WHERE user_id = ? AND process = ?;',
    [userId, process]
  );

  return data[0];
};

module.exports = {
  createProcess,
  getProcesses,
  getProcessesByUser,
  findProcess,
};
