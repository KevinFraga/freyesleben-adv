const { process } = require('../model');

const createProcess = async (processData) => {
  const alreadyExists = await process.findProcess(processData);

  if (alreadyExists)
    return {
      error: {
        statusCode: 409,
        message: 'Process already exists',
      },
    };

  const data = await process.createProcess(processData);

  return data;
};

const getProcesses = async () => await process.getProcesses();

const getProcessesByUser = async (id) => await process.getProcessesByUser(id);

const findProcess = async (processData) => {
  const data = await process.findProcess(processData);

  if (!data)
    return {
      error: {
        statusCode: 404,
        message: 'Process not found',
      },
    };

  return data;
};

module.exports = {
  createProcess,
  getProcesses,
  getProcessesByUser,
  findProcess,
};
