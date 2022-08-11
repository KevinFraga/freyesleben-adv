const { post } = require('../service');

const getAll = async (_req, res, _next) => {
  const postData = await post.getAll();

  return res.status(200).send(postData);
};

const newPost = async (req, res, _next) => {
  const postData = await post.newPost(req.body);

  return res.status(201).json(postData);
};

const deletePost = async (req, res, _next) => {
  const { postId } = req.params;

  const postData = await post.deletePost(postId);

  return res.status(200).json(postData);
};

module.exports = {
  getAll,
  newPost,
  deletePost,
};
