var mysql = require('mysql');

var pool = mysql.createPool({
  host     : 'localhost',
  user     : 'qwar',
  password : 'qwar',
  port : 3306, //port mysql
  database:'qwar'   
});

exports.pool = pool;