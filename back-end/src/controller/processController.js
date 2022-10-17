const { process, user } = require('../service');

const tokenValidator = async (req, _res, next) => {
  const userData = await user.validateToken(req.body);

  if (userData.error) return next(userData);

  return next();
};

const createProcess = async (req, res, next) => {
  const processData = await process.createProcess(req.body);

  if (processData.error) return next(processData);

  return res.status(201).json(processData);
};

const getProcesses = async (_req, res, _next) => {
  const data = await process.getProcesses();

  return res.status(200).send(data);
};

const getProcessesByUser = async (req, res, _next) => {
  const { id } = req.params;

  const processData = await process.getProcessesByUser(id);

  return res.status(200).json(processData);
};

const findProcess = async (req, res, next) => {
  const data = { userId: req.params.id, process: req.params.process }

  const processData = await process.findProcess(data);

  if (processData.error) return next(processData);

  return res.status(200).json(processData);
}

module.exports = {
  tokenValidator,
  createProcess,
  getProcesses,
  getProcessesByUser,
  findProcess,
};
