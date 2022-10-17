const express = require('express');
const multer = require('multer');
const path = require('path');
const middleware = require('../middleware');
const { user, file, process } = require('../controller');

const router = express.Router();

const storage = multer.diskStorage({
  destination: (_req, _file, cb) => cb(null, './public'),
  filename: (req, _file, cb) => {
    const name = `${req.body.name}-${req.body.kind}.${req.body.extension}`;
    req.body.fileName = name;
    req.body.filePath =
      req.body.extension === 'pdf'
        ? path.resolve(`./public/${name}`)
        : `http://localhost:3007/${name}`;
    cb(null, name);
  },
});

const upload = multer({
  storage,
});

router.post('/', user.registerUser);

router.get('/', user.getUsers);

router.post('/login', user.login);

router.get('/email', user.getUserByEmail);

router.post('/token', middleware.tokenValidator, user.tokenValidator);

router.post(
  '/:id/newprocess',
  middleware.tokenValidator,
  process.tokenValidator,
  process.createProcess
);

router.post(
  '/:id/file/upload',
  upload.single('file'),
  middleware.tokenValidator,
  file.tokenValidator,
  file.uploader
);

router.post(
  '/:id/file/upload/profilepic',
  upload.single('file'),
  middleware.tokenValidator,
  file.tokenValidator,
  file.profilepicUploader
);

router.get('/:id/file/download', file.getAllFiles);

router.get('/:id/file/download/:fileType', file.downloader);

module.exports = router;
