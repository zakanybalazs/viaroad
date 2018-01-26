// external imports
const express = require('express');
const bodyParser = require('body-parser');
const path = require('path');
const https = require('https');
const cors = require('cors');
//internal imports
const port = process.env.PORT || 3000;
const {maganTIG} = require('./models/magantig');

var app = express();
var server =  http.createServer(app);
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({extended: true}));
app.use(cors());



app.post('/tig_magan', (req, res) => {
  console.log("new POST on server..");
  console.log(req.body.r);
  var msg = maganTIG({
          text: req.body.r
        });
          res.send(JSON.stringify("ok"));
  });

server.listen(port, () => {
  console.log(`Server started on port ${port}, now with support for cors`);
});
