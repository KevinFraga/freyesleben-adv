const express = require('express');
const bodyParser = require('body-parser');
require('dotenv').config();

const router = require('./router');

const app = express();
app.use(bodyParser.json());

app.use(router);

const port = process.env.PORT || 3001;

app.listen(port, () => {
    console.log(`Server is running on the port ${port}.`);
});
