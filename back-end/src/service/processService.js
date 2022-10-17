const { process } = require('../model');

const createProcess = async (processData) =>
  await process.createProcess(processData);

const getProcesses = async () => await process.getProcesses();

module.exports = {
  createProcess,
  getProcesses,
};
