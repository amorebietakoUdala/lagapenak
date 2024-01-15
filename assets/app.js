/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

import '@popperjs/core';
import 'bootstrap';

import '@fortawesome/fontawesome-free/js/all.js';

global.app_base = '/';
global.locale = $('html').attr("lang");

import { Modal } from 'bootstrap';

document.addEventListener('turbo:before-cache', () => {
   if (document.body.classList.contains('modal-open')) {
       const modalEl = document.querySelector('.modal');
       const modal = Modal.getInstance(modalEl);
       modalEl.classList.remove('fade');
       modal._backdrop._config.isAnimated = false;
       modal.hide();
       modal.dispose();
   }
});