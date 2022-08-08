const { post } = require('../service');

const getAll = async (_req, res, _next) => {
  const postData = await post.getAll();

  return res.status(200).send(postData);
};

module.exports = {
  getAll,
};
