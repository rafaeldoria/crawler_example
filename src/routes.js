module.exports = (app) => {
    app.use('/home', require('./routes/home'))
    app.use('/', require('./routes/crawler'))
}