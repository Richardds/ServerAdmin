window._ = require('lodash');
window.Vue = require('vue');
window.axios = require('axios');
window.Clipboard = require('clipboard');
window.ServerAdmin = require('./serveradmin');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found');
}

// Initialize Clipboard.js
new Clipboard('.btn');
