require('./bootstrap');
require('./components');
require('./utils');

const App = new Vue({
    el: '#root',
    components: {
        //modal: require('vue-strap').modal
    },
    data: {
        showModal: true,
        showStatus: true
    },
    methods: {}
});
