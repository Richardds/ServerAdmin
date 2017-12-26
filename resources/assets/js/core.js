require('./bootstrap');
require('./utils');
require('./components');

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
