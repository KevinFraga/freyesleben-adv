const { post } = require('../model');
const joi = require('joi');

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

const sendEmail = async (emailData) => {
  const schema = joi.object({
    name: joi.string().required(),
    email: joi.string().email().required(),
    subject: joi.string().required(),
    text: joi.string().required(),
  });

  const { error, value } = schema.validate(emailData);

  if (error) {
    return {
      error: {
        statusCode: 400,
        message: error.details[0].message,
      },
    };
  }

  const data = await post.sendEmail(value);

  return { message: 'Email enviado com sucesso'};
}

module.exports = {
  getAllPosts,
  newPost,
  deletePost,
  getAllFeedbacks,
  newFeedback,
  deleteFeedback,
  sendEmail,
};
