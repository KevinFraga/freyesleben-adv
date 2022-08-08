const express = require('express');
const middleware = require('../middleware');
const { post } = require('../controller');

const router = express.Router();

router.get('/', post.getAll);

module.exports = router;
