const mysql = require('mysql2/promise');

const connect = mysql.createPool({
    host: 'localhost',
    user: 'dev',
    password: 'senha',
    database: 'freyesleben_adv'
});

module.exports = connect;
