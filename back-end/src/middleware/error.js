const error = (err, _req, res, _next) =>
  res.status(err.error.statusCode).json({ message: err.error.message });

module.exports = error;
