const express = require('express');

const router = express.Router();

const { user } = require('../controller');

router.post('/', user.registerUser);

module.exports = router;
