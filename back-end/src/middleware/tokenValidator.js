const jwt = require('jsonwebtoken');

const secret = process.env.SECRET || 'segredo';

const tokenValidator = (req, _res, next) => {
  const { token } = req.body;

  if (!token) {
    return next({
      error: {
        statusCode: 400,
        message: 'Token is required',
      },
    });
  }

  jwt.verify(token, secret, (err, decoded) => {
    if (err) {
      return next({
        error: {
          statusCode: 401,
          message: err,
        },
      });
    }

    req.body.decoded = decoded;
    
    return next();
  });
};

module.exports = tokenValidator;
