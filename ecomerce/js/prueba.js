
import mysql from '../node_modules/mysql/index.js';

function setOrden(){
  


  var con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "prueva"
  });
  
  con.connect(function(err) {
    if (err) throw err;
    let mensaje = "Connected!"
  });
  
  
  con.end()
  return mensaje


}

