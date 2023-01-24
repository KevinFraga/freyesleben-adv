const connect = require('./connection');

const registerFile = async ({
  userId,
  kind,
  process,
  fileName,
  filePath,
  contentType,
}) => {
  const alreadyExists = await findFile(userId, kind);

  if (!alreadyExists) {
    const [_data] = await connect.query(
      'INSERT INTO files (user_id, kind, name, path, content_type, process) VALUES (?, ?, ?, ?, ?, ?);',
      [userId, kind, fileName, filePath, contentType, process]
    );
  }

  const [count] = await connect.query(
    'SELECT COUNT(DISTINCT kind) AS count FROM files WHERE user_id = ? AND process = ?;',
    [userId, process]
  );

  if (count[0].count >= 3) updateStep(userId, process);

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
    'SELECT DISTINCT(name), kind, path, content_type, process FROM files WHERE user_id = ?;',
    [id]
  );

  return data;
};

const updateStep = async (id, process) => {
  const [contract] = await connect.query(
    "SELECT * FROM files WHERE user_id = ? AND process = ? AND kind = 'Contrato Assinado';",
    [id, process]
  );

  if (contract[0]) {
    updateNextStep(id, process);
  } else {
    const [_data] = await connect.query(
      "UPDATE userProcesses SET step = 'Documentos recebidos, por favor assine e nos envie o seu contrato conosco.', documentation = 50 WHERE user_id = ? AND process = ?;",
      [id, process]
    );
  }
};

const updateNextStep = async (id, process) => {
  const [payment] = await connect.query(
    "SELECT * FROM files WHERE user_id = ? AND process = ? AND kind = 'Comprovante de Pagamento';",
    [id, process]
  );

  if (payment[0]) {
    updateLastStep(id, process);
  } else {
    const [_data] = await connect.query(
      "UPDATE userProcesses SET step = 'Contrato recebido, por favor realize o pagamento e nos envie o comprovante para iniciarmos o processo.', documentation = 75 WHERE user_id = ? AND process = ?;",
      [id, process]
    );
  }
};

const updateLastStep = async (id, process) => {
  const [_data] = await connect.query(
    "UPDATE userProcesses SET step = 'Processo aguardando protocolo.', stage = 1, documentation = 100 WHERE user_id = ? AND process = ?;",
    [id, process]
  );
};

const getFileKind = async () => {
  const [data] = await connect.query('SELECT name FROM fileKind;');

  return data;
};

module.exports = {
  registerFile,
  findFile,
  getAllFiles,
  registerProfilepic,
  getFileKind,
};
