const express = require('express');

const router = express.Router();

const { user } = require('../controller');

router.post('/', user.registerUser);

router.get('/', user.getUsers);

router.get('/email', user.getUserByEmail);

module.exports = router;
