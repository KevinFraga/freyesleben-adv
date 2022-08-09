const { post } = require('../service');

const getAll = async (_req, res, _next) => {
  const postData = await post.getAll();

  return res.status(200).send(postData);
};

const newPost = async (req, res, next) => {
  const postData = await post.newPost(req.body);

  if (postData.error) return next(postData);

  return res.status(201).json(postData);
};

module.exports = {
  getAll,
  newPost,
};
