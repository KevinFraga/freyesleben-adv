const { file, user } = require('../service');
const fs = require('fs');

const uploader = async (req, res, next) => {
  const fileData = await file.uploader(req.body);

  if (fileData.error) return next(fileData);

  return res.status(201).json(fileData);
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

  const file = fs.createReadStream(fileData.path);

  const fileName = fileData.fileName;

  res.setHeader('Content-Disposition', `attachment: filename="${fileName}"`);

  await file.pipe(res);

  return res.status(200);
};

module.exports = {
  uploader,
  tokenValidator,
  downloader,
};
