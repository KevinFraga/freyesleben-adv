const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
require('dotenv').config();

const router = require('./router');

const app = express();
app.use(bodyParser.json());
app.use(cors());

app.use(router);

const port = process.env.PORT || 3001;

app.listen(port, () => {
    console.log(`Server is running on the port ${port}.`);
});
