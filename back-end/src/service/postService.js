const { post } = require('../model');

const getAll = async () => await post.getAll();

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

module.exports = {
  getAll,
  newPost,
  deletePost,
};
