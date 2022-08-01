const { file } = require('../model');

const uploader = async (fileData) => {
  const { userId, fileType, fileName, filePath } = fileData;

  const newFile = {
    fileName,
    fileType,
    userId,
    filePath,
  };

  const data = await file.registerFile(newFile);

  return { message: `${data.fileName} recebido com sucesso` };
};

module.exports = {
  uploader,
};
