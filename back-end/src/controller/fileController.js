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

  const fileReader = await fs.createReadStream(fileData.path);

  res.setHeader('Content-Disposition', `attachment; filename="${fileData.name}.png"`);

  res.setHeader('Content-Type', 'image/png');

  return fileReader.pipe(res);
};

module.exports = {
  uploader,
  tokenValidator,
  downloader,
};
