const { post } = require('../model');

const getAll = async () => await post.getAll();

module.exports = {
  getAll,
};
