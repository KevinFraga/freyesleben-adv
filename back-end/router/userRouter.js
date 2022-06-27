const express = require('express');

const router = express.Router();

const { user } = require('../controller');

router.post('/', user.registerUser);

router.get('/', user.getUsers);

module.exports = router;
