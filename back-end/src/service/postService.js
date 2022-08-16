const { post } = require('../model');

const getAllPosts = async () => await post.getAllPosts();

const newPost = async (postData) => {
  const { title, text } = postData;

  const newPost = {
    title,
    text,
  };

  const data = await post.registerPost(newPost);

  return data;
};

const deletePost = async (postId) => await post.deletePost(postId);

const getAllFeedbacks = async () => await post.getAllFeedbacks();

const newFeedback = async (postData) => {
  const { title, text, userId } = postData;

  const newPost = {
    title,
    text,
    userId,
  };

  const data = await post.registerFeedback(newPost);

  return data;
};

const deleteFeedback = async (postId) => await post.deleteFeedback(postId);

module.exports = {
  getAllPosts,
  newPost,
  deletePost,
  getAllFeedbacks,
  newFeedback,
  deleteFeedback,
};
