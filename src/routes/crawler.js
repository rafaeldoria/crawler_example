const express = require('express')
const request = require('request')
const cheerio = require('cheerio')
const router = express.Router()

router.get('/', (req, res) => {
    res.render('crawler/index', {
        title: 'WEB Crawler',
        msg: 'Parameters to Crawler'
    })
})

router.post('/', (req, res) => {
    if (!req.body) {
        return res.redirect('/')
    }

    let type = req.body.type
    let mark = req.body.mark
    let name = req.body.uno
    let init_year = req.body.init_year
    let end_year = req.body.end_year
    let min_price = req.body.min_price
    let max_price = req.body.max_price

    let url = 'https://seminovos.com.br/' + type + '/' + mark + '/' + name + '/ano-' + init_year + '-' + end_year + '/preco-' + min_price + '-' + max_price
    console.log(url)
})

module.exports = router