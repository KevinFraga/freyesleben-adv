const jwt = require('jsonwebtoken');

const secret = process.env.SECRET || 'segredo';

const tokenMaker = (userData) => {
  const token = jwt.sign(
    userData,
    secret,
    {
      algorithm: 'HS256',
      expiresIn: '30m'
    }
  );
  
  return token;
}

module.exports = tokenMaker;
