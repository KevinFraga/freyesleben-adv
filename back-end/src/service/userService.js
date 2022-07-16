const { user } = require('../model');
const md5 = require('md5');
const joi = require('joi');
const middleware = require('../middleware');

const registerUser = async (userData) => {
  const schema = joi.object({
    name: joi.string().required(),
    email: joi.string().email().required(),
    password: joi.string().required(),
  });

  const { error, value } = schema.validate(userData);

  if (error) {
    return {
      error: {
        statusCode: 400,
        message: error.details[0].message,
      },
    };
  }

  const isRegistered = await user.getUserByEmail(value.email);

  if (isRegistered) {
    return {
      error: {
        statusCode: 409,
        message: 'User already exists',
      },
    };
  }

  const encrypt = {
    name: value.name,
    email: value.email,
    password: md5(value.password),
  };

  const resgister = await user.registerUser(encrypt);

  return resgister;
};

const getUsers = async () => await user.getUsers();

const getUserByEmail = async (userEmail) => {
  const { email } = userEmail;

  const data = await user.getUserByEmail(email);

  return data;
};

const login = async (userData) => {
  const schema = joi.object({
    email: joi.string().email().required(),
    password: joi.string().required(),
  });

  const { error, value } = schema.validate(userData);

  if (error) {
    return {
      error: {
        statusCode: 400,
        message: error.details[0].message,
      },
    };
  }

  const isRegistered = await user.getUserByEmail(value.email);

  if (!isRegistered) {
    return {
      error: {
        statusCode: 404,
        message: 'User not found',
      },
    };
  }

  if (isRegistered.password !== md5(value.password)) {
    return {
      error: {
        statusCode: 403,
        message: 'Password does not match',
      },
    };
  }

  const token = middleware.tokenMaker(isRegistered)

  return { token };
};

module.exports = {
  registerUser,
  getUsers,
  getUserByEmail,
  login,
};
