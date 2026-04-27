import './bootstrap';
import Chart from 'chart.js/auto';

// Paksa ke global window
window.Chart = Chart;

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Tambahkan ini untuk debug di console browser
console.log('Chart.js telah dimuat ke window.Chart');
