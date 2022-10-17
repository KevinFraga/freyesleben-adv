const { post } = require('../service');

const getAllPosts = async (_req, res, _next) => {
  const postData = await post.getAllPosts();

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

const getAllFeedbacks = async (_req, res, _next) => {
  const postData = await post.getAllFeedbacks();

  return res.status(200).send(postData);
};

const newFeedback = async (req, res, _next) => {
  const postData = await post.newFeedback(req.body);

  return res.status(201).json(postData);
};

const deleteFeedback = async (req, res, _next) => {
  const { postId } = req.params;

  const postData = await post.deletePost(postId);

  return res.status(200).json(postData);
};

const sendEmail = async (req, res, next) => {
  const emailData = await post.sendEmail(req.body);

  if (emailData.error) return next(emailData);

  return res.status(201).json(emailData);
};

const getFileKind = async (_req, res, _next) => {
  const data = await post.getFileKind();

  return res.status(200).send(data);
};

const getProcesses = async (_req, res, _next) => {
  const data = await post.getProcesses();

  return res.status(200).send(data);
};

module.exports = {
  getAllPosts,
  newPost,
  deletePost,
  getAllFeedbacks,
  newFeedback,
  deleteFeedback,
  sendEmail,
  getFileKind,
  getProcesses,
};
