require('../css/app.scss');
require('popper.js');
require('bootstrap');

import noUiSlider from 'nouislider'
import 'nouislider/distribute/nouislider.css'
import Filter from './modules/Filter'

 new Filter(document.querySelector('.js-filter'))

 const slider = document.getElementById('price-slider');
if (slider){
    const min = document.getElementById('prixMin')
    const max = document.getElementById('prixMax')
    const minValue = Math.floor(parseInt(slider.dataset.min,10) / 10) * 10
    const maxValue = Math.ceil(parseInt(slider.dataset.max,10) / 10) * 10
    const range = noUiSlider.create(slider, {
        start: [min.value || minValue, max.value || maxValue],
        connect: true,
        step: 10,
        range: {
            'min': minValue,
            'max': maxValue
        }

    })
    range.on('slide', function (values, handle) {
        if (handle === 0){
            min.value = Math.round(values[0])
        }
        if (handle === 1){
            max.value = Math.round(values[1])
        }
    })
   }



// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

