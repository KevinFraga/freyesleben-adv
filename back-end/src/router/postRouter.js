const express = require('express');
const middleware = require('../middleware');
const { post } = require('../controller');

const router = express.Router();

router.get('/', post.getAllPosts);

router.get('/filekind', post.getFileKind);

router.get('/processes', post.getProcesses);

router.get('/feedback', post.getAllFeedbacks);

router.post('/new', post.newPost);

router.post('/feedback/new', post.newFeedback);

router.post('/email', post.sendEmail);

router.delete('/:postId', post.deletePost);

router.delete('/feedback/:postId', post.deleteFeedback);

module.exports = router;
