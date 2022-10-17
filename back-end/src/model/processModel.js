const connect = require('./connection');

const createProcess = async ({ userId, process }) => {
  const [_data] = await connect.query(
    "INSERT INTO userProcesses(user_id, process, step, stage, color) VALUES (?, ?, 'Processo iniciado, por favor envie os seus documentos para continuarmos.', 0, 'green');",
    [userId, process]
  );

  return { message: 'Processo criado com sucesso.' };
};

const getProcesses = async () => {
  const [data] = await connect.query('SELECT name FROM processes;');

  return data;
};

module.exports = {
  createProcess,
  getProcesses,
};
