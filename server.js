// listen requests from sigfox backend

var http = require('http');
var mysql = require('mysql');
var express = require('express');
var bodyParser = require("body-parser");
var moment = require('moment');
var config = require('./config.json');
var axios = require('axios');

var app = express();
var mysql_conn;
var data_table = 'messages';

app.use(bodyParser.json());

app.post('/', function (req, res) {

    console.log('[Message] Incoming message...');
    // validate token
    if (req.headers && req.headers.token === config.auth.token) {
        if (req.body) {

            let sql_find = 'SELECT * FROM ' + data_table + ' WHERE seqNumber = ' + req.body.seqNumber + ' LIMIT 1';
            mysql_conn.query(sql_find, function (error, result) {
                if (error) {
                    console.log('[Error] sql_find' + error);
                    return;
                }

                if (result.length === 0) {
                    // a new record arrived, insert it
                    let sql_insert = 'INSERT INTO ' + data_table + ' SET ?';
                    req.body.created_at = req.body.updated_at = moment().format('YYYY-MM-DD hh:mm:ss');

                    mysql_conn.query(sql_insert, req.body, function (error, result) {
                        if (error) {
                            console.log('[Error] Uable to insert into database.\n' + error);
                        } else {
                            console.log('[Message] Incoming message inserted. seqNumber:' + req.body.seqNumber);
                            axios({
                                url: 'http://localhost/api/message',
                                method: 'post',
                                headers: {
                                    token: config.auth.token
                                },
                                data: {
                                    id: result.insertId
                                }
                            }).then(function (result) {
                                console.log('[Message] Message delivered, id:' + result.insertId);
                                // console.log(result);
                            }).catch(function (error) {
                                console.log('[Error] Failed to deliver message.');
                                console.log(error);
                            })
                        }
                    });
                } else {
                    console.log('[Duplicate] Duplicate mesage with seqNumber: ' + req.body.seqNumber);
                }
            });
        }
    } else {
        console.log('[Error] An unauthorized request occurred:');
        console.log(req.headers);
        console.log(req.body);
    }
    res.end();

});

http.createServer(app)
    .listen(config.server.port, function () {
        console.log('[Server] Server starting at port' + config.server.port);
        try {
            mysql_conn = mysql.createPool(config.server.db);
        } catch (e) {
            console.log(e);
            process.exit();
        }
    });
