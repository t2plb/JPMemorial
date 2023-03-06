/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// require jQuery normally
const $ = require('jquery');

// create global $ and jQuery variables
global.$ = global.jQuery = $;

import 'admin-lte/dist/js/adminlte.min';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'admin-lte/dist/css/adminlte.min.css';
import './styles/navbar.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
import './styles/font.scss';
import './styles/darkbutton.scss';
import './styles/flipcard.css'

// start the Stimulus application
import './bootstrap';
import '@hotwired/stimulus';
import './controllers/darkbutton_controller'