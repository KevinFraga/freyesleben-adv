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

const downloader = async (id, fileType) => {
  const data = await file.findFile(id, fileType);

  if (!data) {
    return {
      error: {
        statusCode: 404,
        message: 'File not found',
      },
    };
  }

  return data;
};

module.exports = {
  uploader,
  downloader,
};
