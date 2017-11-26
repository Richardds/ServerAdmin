require('./bootstrap');
require('./components');
require('./utils');

window._config = require('./config');

const App = new Vue({
    el: '#root',
    components: {
        //
    },
    data: {
        showModal: true,
        showStatus: true
    },
    methods: {
        config(key) {
            return window._config[key];
        }
    }
});
