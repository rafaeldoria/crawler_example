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
    
    request(url, (err, response, body) => {
        if (err || response.statusCode != 200) {
            return;
        }

        let $ = cheerio.load(body)
        let data = []

        $('.card-content').each((key, element) => {
            let elementTitle = $(element).find('.card-heading > .card-title').text()
            let elementprice = $(element).find('.card-heading > .card-price').text()
            let elementSubtitle = ($(element).find('.card-info > .card-features > .card-subtitle').text()).substring(9)
            let elementYear = ($(element).find('.card-info > .card-features > .list-features > li[title|="Ano de fabricação"]').text()).substring(2)
            let elementKm = (($(element).find('.card-info > .card-features > .list-features > li[title|="Kilometragem atual"]').text()).substring(2)).slice(0, -1)
            let elementLink = ('https://seminovos.com.br/' + $(element).find('a').attr('href')).split('/')
            elementLink = elementLink[0] + '/' + elementLink[2] + '/' + elementLink[4]

            data.push({
                elementTitle,
                elementprice,
                elementSubtitle,
                elementYear,
                elementKm,
                elementLink
            })
        })

        res.status(200).json(data)
    })

    
})

module.exports = router