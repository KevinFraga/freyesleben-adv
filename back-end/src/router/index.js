const express = require('express');
const user = require('./userRouter');
const post = require('./postRouter');

const router = express.Router();

router.use('/user', user);

router.use('/post', post);

module.exports = router;
