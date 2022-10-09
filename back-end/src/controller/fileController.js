const { file, user } = require('../service');
const fs = require('fs');

const uploader = async (req, res, next) => {
  const fileData = await file.uploader(req.body);

  if (fileData.error) return next(fileData);

  return res.status(201).json(fileData);
};

const profilepicUploader = async (req, res, next) => {
  const profilepicData = await file.profilepicUploader(req.body);

  if (profilepicData.error) return next(profilepicData);

  return res.status(201).json(profilepicData);
};

const tokenValidator = async (req, _res, next) => {
  const userData = await user.validateToken(req.body);

  if (userData.error) return next(userData);

  return next();
};

const downloader = async (req, res, next) => {
  const { id, fileType } = req.params;

  const fileData = await file.downloader(id, fileType);

  if (fileData.error) return next(fileData);

  const fileReader = await fs.createReadStream(fileData.path);

  res.setHeader(
    'Content-Disposition',
    `attachment; filename="${fileData.name}"`
  );

  res.setHeader('Content-Type', fileData.content_type);

  return fileReader.pipe(res);
};

const getAllFiles = async (req, res, _next) => {
  const { id } = req.params;

  const fileData = await file.getAllFiles(id);

  return res.status(200).json(fileData);
};

module.exports = {
  uploader,
  tokenValidator,
  downloader,
  getAllFiles,
  profilepicUploader,
};
