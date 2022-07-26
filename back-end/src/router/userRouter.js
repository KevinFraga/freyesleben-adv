const express = require('express');

const router = express.Router();

const { user } = require('../controller');
const middleware = require('../middleware');

router.post('/', user.registerUser);

router.get('/', user.getUsers);

router.post('/login', user.login);

router.get('/email', user.getUserByEmail);

router.post('/token', middleware.tokenValidator, user.tokenValidator);

module.exports = router;
