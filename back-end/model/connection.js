const mysql = require('mysql');

const con = mysql.createPool({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'freyesleben_adv'
});

module.exports = con;