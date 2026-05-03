import './bootstrap';
import './bulk-delete';
import Chart from 'chart.js/auto';
import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css';

window.TomSelect = TomSelect;


// Paksa ke global window
window.Chart = Chart;

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

