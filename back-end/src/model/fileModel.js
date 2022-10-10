const connect = require('./connection');

const registerFile = async ({
  userId,
  kind,
  fileName,
  filePath,
  contentType,
}) => {
  const alreadyExists = await findFile(userId, kind);

  if (!alreadyExists) {
    const [_data] = await connect.query(
      'INSERT INTO files (user_id, kind, name, path, content_type) VALUES (?, ?, ?, ?, ?);',
      [userId, kind, fileName, filePath, contentType]
    );
  }

  const [count] = await connect.query(
    'SELECT COUNT(DISTINCT kind) AS count FROM files WHERE user_id = ?',
    [userId]
  );

  if (count[0].count >= 3) updateStep(userId);

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

const updateStep = async (id) => {
  const [contract] = await connect.query(
    "SELECT * FROM files WHERE user_id = ? AND kind = 'Contrato';",
    [id]
  );

  if (contract) {
    updateNextStep(id);
  } else {
    const [_data] = await connect.query(
      "UPDATE users SET step = 'Documentos recebidos, por favor assine e nos envie o seu contrato conosco.' WHERE id = ?;",
      [id]
    );
  }
};

const updateNextStep = async (id) => {
  const [payment] = await connect.query(
    "SELECT * FROM files WHERE user_id = ? AND kind = 'Comprovante de Pagamento';",
    [id]
  );

  if (payment) {
    updateLastStep(id);
  } else {
    const [_data] = await connect.query(
      "UPDATE users SET step = 'Contrato recebido, por favor realize o pagamento e nos envie o comprovante para iniciarmos o processo.' WHERE id = ?;",
      [id]
    );
  }
}

const updateLastStep = async (id) => {
  const [_data] = await connect.query(
    "UPDATE users SET step = 'Processo protocolado.', process = 1 WHERE id = ?;",
    [id]
  );
}

module.exports = {
  registerFile,
  findFile,
  getAllFiles,
  registerProfilepic,
};
