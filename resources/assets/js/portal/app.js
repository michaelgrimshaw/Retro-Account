require('./bootstrap');
require('jquery.cookie');
require('chart.js');
require('bootstrap-datepicker')

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

$('.datepicker').datepicker({
    setDate: new Date(),
    format: 'yyyy-mm-dd'
});




