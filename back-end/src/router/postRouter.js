const express = require('express');
const middleware = require('../middleware');
const { post } = require('../controller');

const router = express.Router();

router.get('/', post.getAll);

router.post('/new', post.newPost);

router.delete('/:postId', post.deletePost);

module.exports = router;
