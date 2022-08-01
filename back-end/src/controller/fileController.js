const { file, user } = require('../service');

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

module.exports = {
  uploader,
  tokenValidator,
};
