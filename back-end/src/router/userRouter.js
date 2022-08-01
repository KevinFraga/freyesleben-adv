const express = require('express');
const { required } = require('joi');
const multer = require('multer');

const router = express.Router();

const storage = multer.diskStorage({
  destination: (_req, _file, cb) => cb(null, './public'),
  filename: (req, _file, cb) => {
    const name = `${req.body.userId}-${req.body.fileType}`;
    req.body.fileName = name;
    req.body.filePath = `./public/${name}`;
    cb(null, name);
  },
});

const upload = multer({
  storage,
});

const { user, file } = require('../controller');

const middleware = require('../middleware');

router.post('/', user.registerUser);

router.get('/', user.getUsers);

router.post('/login', user.login);

router.get('/email', user.getUserByEmail);

router.post('/token', middleware.tokenValidator, user.tokenValidator);

router.post(
  '/:id/file/upload',
  upload.single('file'),
  middleware.tokenValidator,
  file.tokenValidator,
  file.uploader
);

module.exports = router;
