import './bootstrap';
import './layout';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Plugin
import SimpleBar from 'simplebar';
import feather from 'feather-icons';
import Waves from 'node-waves';
import flatpickr from 'flatpickr';
import ApexCharts from 'apexcharts';

window.ApexCharts = ApexCharts;
window.feather = feather;
window.Waves = Waves;
window.flatpickr = flatpickr;
window.SimpleBar = SimpleBar;

// dynamic import
const page = document.body.dataset.page;

switch (page) {
  case 'login':
    import('./pages/password-addon.init.js');
    import('./pages/form-validation.init.js');
    break;
  case 'register':
    import('./pages/form-validation.init.js');
    break;
  case 'reset-password':
    import('./pages/password-create.init.js');
  default:
}