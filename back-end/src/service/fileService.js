const { file } = require('../model');

const uploader = async (fileData) => {
  const { userId, kind, fileName, filePath, contentType, process } = fileData;

  const newFile = {
    fileName,
    kind,
    process,
    userId,
    filePath,
    contentType
  };

  const data = await file.registerFile(newFile);

  return { message: `${data.fileName} recebido com sucesso` };
};

const profilepicUploader = async (fileData) => {
  const { userId, kind, fileName, filePath, contentType } = fileData;

  const newFile = {
    fileName,
    kind,
    userId,
    filePath,
    contentType
  };

  const data = await file.registerProfilepic(newFile);

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

const getAllFiles = async (id) => await file.getAllFiles(id);

const getFileKind = async () => await file.getFileKind();

module.exports = {
  uploader,
  downloader,
  getAllFiles,
  profilepicUploader,
  getFileKind,
};
