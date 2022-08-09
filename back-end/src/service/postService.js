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

module.exports = {
  getAll,
  newPost,
};
