const mongoose = require('mongoose');

//config for the mongoose db handler
mongoose.Promise = global.Promise;
mongoose.connect('mongodb://localhost:27017/TodoApp');
// export the configured mongoose var
module.exports = {mongoose}
