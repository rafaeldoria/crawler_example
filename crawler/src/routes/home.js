const express = require('express')
const router = express.Router()

router.get('/', (req, res) => {
    res.render('layouts/home', {
        title: 'WEB Crawler',
        msg  : 'Welcome to Home Web Crawler'
    })
})

module.exports = router